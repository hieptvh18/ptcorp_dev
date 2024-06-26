<?php

namespace Modules\Auth\Services\User;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Auth\Models\Role;
use Modules\Lms\Models\Member;
use Modules\Lms\Models\LmsRole;
use App\Exceptions\ApiException;
use Modules\Auth\Models\Teamwork;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Modules\Auth\Enums\UserInfoType;
use Illuminate\Support\Facades\Storage;
use Modules\Auth\Events\UserRegisterAfter;
use Illuminate\Support\Facades\Notification;
use Modules\Auth\Repositories\WorkspaceInfoRepository;
use Modules\Auth\Notifications\InvitedTeamNotification;
use Mpociot\Teamwork\Exceptions\UserNotInTeamException;
use Modules\Auth\Notifications\RegisterAccountNotification;
use Modules\Auth\Events\EventWorkspaceInfoServiceCreateAfter;
use Modules\Auth\Notifications\WorkspaceAddMemberNotification;
use Modules\Auth\Events\EventWorkspaceInfoServiceAddMembersAfter;

class WorkspaceInfoService extends BaseService
{
    public function __construct(WorkspaceInfoRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function create(Request $request)
    {
        try {
            $images_avatar_tmp = Storage::disk('s3')->allFiles('workspace/alias/avatar_workspace_tmp');
            $image_url = '';
            foreach ($images_avatar_tmp as $image_avatar_tmp) {
                if ($request->avatar_url === $image_avatar_tmp) {
                    $image_url = str_replace('workspace/alias/avatar_workspace_tmp', 'workspace/alias/avatar_workspace', $image_avatar_tmp);
                    Storage::disk('s3')->move($image_avatar_tmp, $image_url);
                    Storage::disk('s3')->deleteDirectory('workspace/alias/avatar_workspace_tmp');
                }
            };
            DB::beginTransaction();
            $data = $request->all();
            $data['alias'] = $request->short_name;
            $data['avatar_url'] = $image_url;
            $item = $this->baseRepository->create($data);
            DB::commit();
            event(new EventWorkspaceInfoServiceCreateAfter($item));
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (in_array('update', $this->allowPolicies)) {
                $this->authorize('update', $id);
            }
            $images_avatar_tmp = Storage::disk('s3')->allFiles('workspace/alias/avatar_workspace_tmp');
            $avatar_url = '';
            foreach ($images_avatar_tmp as $image_avatar_tmp) {
                if ($request->avatar_url === $image_avatar_tmp) {
                    $avatar_url = str_replace('workspace/alias/avatar_workspace_tmp', 'workspace/alias/avatar_workspace', $image_avatar_tmp);
                    Storage::disk('s3')->move($image_avatar_tmp, $avatar_url);
                    Storage::disk('s3')->deleteDirectory('workspace/alias/avatar_workspace_tmp');
                }
            }
            if (!$avatar_url) {
                $avatar_url = $request->avatar_url;
            }

            $images_background_tmp = Storage::disk('s3')->allFiles('workspace/alias/background_workspace_tmp');
            $background_url = '';
            foreach ($images_background_tmp as $image_background_tmp) {
                if ($request->background_image_url === $image_background_tmp) {
                    $banner_url = str_replace('workspace/alias/background_workspace_tmp', 'workspace/alias/background_workspace', $image_background_tmp);
                    Storage::disk('s3')->move($image_background_tmp, $banner_url);
                    Storage::disk('s3')->deleteDirectory('workspace/alias/background_workspace_tmp');
                }
            }

            DB::beginTransaction();
            $data = $request->all();
            $data['avatar_url'] = $avatar_url;
            $data['background_image_url'] = $background_url;
            $item = $this->baseRepository->update($data, $id);
            $team = $item->team;
            $team->quizSchoolLevels()->sync($request->level_school_ids);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getMyAccessWorkspace(Request $request)
    {
        $user = auth()->user();
        $collection = $this->baseRepository->with('team.quizSchoolLevels')
            ->whereHas('team', function ($query) use ($user) {
                $query->whereHas('users', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                });
            })->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        $collection = $collection->setCollection($collection->getCollection()
            ->map(function ($item) {
                $team = $item->team;
                $item['members'] = $team->users;
                $item['count_members'] = count($item['members']);
                return $item;
            }));
        return $collection;
    }

    public function addMembers($id, Request $request)
    {
        try {
            $user = auth()->user();
            $arr_user_emails = $request->input('emails');

            $team = Teamwork::findOrFail($id);
            $workspace = $team->teamable;
            if ($user->isOwnerOfTeam($team) == false) {
                throw new ApiException('Bạn không có quyền!!', 401);
            }

            foreach ($arr_user_emails as $user_email) {
                $user_check = User::where('email', $user_email)->first();
                if (!$user_check) {
                    $arr = explode('@', $user_email);
                    $user_name = array_shift($arr);
                    $password = 'eduquiz123@';
                    $new_user = User::create([
                        'username' => $user_name,
                        'email' => $user_email,
                        'mobile' => '0988888888',
                        'password' => Hash::make($password),
                    ]);
                    $new_user->info()->create([
                        'first_name' => $user_name,
                        'last_name' => $user_name,
                        'type' => UserInfoType::STUDENT,
                    ]);
                    $new_user->save();
                    $new_user->attachTeam($team);
                    $new_user_ = $new_user;

                    $data = [
                        'user' => $user,
                        'password' => $password
                    ];
                    Notification::send($new_user, new RegisterAccountNotification($data));
                } else {
                    $user_check->attachTeam($team);
                    $new_user_ = $user_check;
                }
                event(new EventWorkspaceInfoServiceAddMembersAfter($workspace, $new_user_));
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function switchWorkspace(Request $request)
    {
        try {
            $user = auth()->user();
            $workspace_id = $request->workspace_id;
            $workspace = $this->baseRepository->find($workspace_id);
            $team = $workspace->team;
            DB::beginTransaction();
            $user->switchTeam($team->id);
            DB::commit();
            return true;
        } catch (UserNotInTeamException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function detachTeamWork($id, Request $request)
    {
        try {
            $team = Teamwork::findOrFail($id);
            $workspace = $team->teamable;
            $user = auth()->user();
            if ($user->isOwnerOfTeam($team) == false) {
                throw new ApiException('Bạn không có quyền!!', 401);
            }
            DB::beginTransaction();
            foreach($request->user_ids as $user_id){
                $user_left = User::find($user_id);
                $user_left->detachTeam($team);
            }
            Http::post(config('auth.service_url.lms')."/lms/api/public/v1/remove-member-workspace", [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'wp_alias' => $workspace->alias,
                'user_ids' => $request->user_ids,
            ]);

            DB::commit();
            return true;
        } catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
