<?php

namespace Modules\Auth\Services\User;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Exception;
use Mpociot\Teamwork\TeamInvite;
use Modules\Auth\Models\Teamwork;
use Illuminate\Support\Facades\DB;
use Modules\Company\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Enums\UserInfoType;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Auth\Events\UserRegisterAfter;
use Modules\Auth\Notifications\InvitedTeamNotification;
use Mpociot\Teamwork\Facades\Teamwork as FacadesTeamwork;
use Modules\Auth\Notifications\RegisterAccountNotification;
use Modules\Company\Repositories\CompanyRepository;
use ParagonIE\Sodium\Compat;

class TeamWorkService extends BaseService
{
    public function __construct(CompanyRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function inviteTeamWork($id, Request $request)
    {
        try {
            $user = auth()->user();
            $arr_user_emails = $request->input('emails');
            $base_url = $request->base_url;
            $team = Teamwork::findOrFail($id);
            if ($user->isOwnerOfTeam($team) == false) {
                throw new ApiException('Bạn không có quyền!!', 401);
            }
            DB::beginTransaction();
            foreach ($arr_user_emails as $user_email) {
                if (!FacadesTeamwork::hasPendingInvite($user_email, $team)) {
                    $user_check = User::where('email', $user_email)->first();
                    if (!$user_check) {
                        $arr = explode('@', $user_email);
                        $user_name = array_shift($arr);
                        $password = 'eduquiz123@';
                        $user = User::create([
                            'username' => $user_name,
                            'email' => $user_email,
                            'mobile' => '0988888888',
                            'password' => Hash::make($password),
                        ]);
                        $user->info()->create([
                            'first_name' => $user_name,
                            'last_name' => $user_name,
                            'type' => UserInfoType::STUDENT,
                        ]);
                        $user->save();
                        event(new UserRegisterAfter($user));
                        $data = [
                            'user' => $user,
                            'password' => $password
                        ];
                        Notification::send($user, new RegisterAccountNotification($data));
                    }
                    FacadesTeamwork::inviteToTeam($user_email, $team, function ($invite) use ($base_url) {

                        Notification::route('mail', $invite->email)->notify(new InvitedTeamNotification($invite->team, $invite, $base_url));
                        // Mail::send('teamwork.emails.invite', ['team' => $invite->team, 'invite' => $invite], function ($m) use ($invite) {
                        //     $m->to($invite->email)->subject('Invitation to join team ' . $invite->team->name);
                        // });

                    });
                }
            }
            DB::commit();
            return true;
        } catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function acceptInvite($id, $token)
    {
        $invite = FacadesTeamwork::getInviteFromAcceptToken($token);
        if (!$invite) {
            abort(404);
        }
        if (auth()->check()) {
            FacadesTeamwork::acceptInvite($invite);
            return true;
        }
    }

    public function denyInvite($id, $token)
    {
        $invite = FacadesTeamwork::getInviteFromDenyToken($token);
        if (!$invite) {
            abort(404);
        }
        if (auth()->check()) {
            FacadesTeamwork::denyInvite($invite);
            return true;
        }
    }

    public function myInvited(Request $request)
    {
        $user = auth()->user();
        $limit = request()->query('size') ?? 12;
        $sort = request()->query('sort', 'updated_at');
        $dir = request()->query('dir', 'DESC');

        $my_invited = TeamInvite::where('email', $user->email)
            ->with(['user', 'team' => function ($query) {
                $query->with('teamable');
            }])

            ->orderBy($sort, $dir)
            ->paginate($limit);
        return $my_invited;
    }

    public function joinedTeamWorks(Request $request)
    {
        $user = auth()->user();
        $limit = request()->query('size') ?? 12;
        $sort = request()->query('sort', 'updated_at');
        $dir = request()->query('dir', 'DESC');

        $collection = $this->baseRepository->whereHas('team', function ($query) use ($user) {
            $query->whereHas('users', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            });
        })->orderBy($sort, $dir)
            ->paginate($limit);
        return $collection;
    }

    public function cancelInvitation($id, $id_invite)
    {
        try {
            DB::beginTransaction();
            $invite = TeamInvite::find($id_invite);
            FacadesTeamwork::denyInvite($invite);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
