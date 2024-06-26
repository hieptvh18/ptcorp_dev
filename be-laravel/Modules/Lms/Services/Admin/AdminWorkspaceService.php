<?php

namespace Modules\Lms\Services\Admin;

use Exception;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Lms\Models\Event;
use Modules\Lms\Models\Major;
use Modules\Lms\Models\Member;
use Modules\Lms\Models\LmsRole;
use Modules\Lms\Models\Subject;
use App\Exceptions\ApiException;
use Modules\Lms\Models\ClassRoom;
use Illuminate\Support\Facades\DB;
use Modules\Lms\Models\SchoolLevel;
use Illuminate\Support\Facades\Http;
use Modules\Lms\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Modules\Lms\Repositories\MemberRepository;
use Modules\Auth\Repositories\WorkspaceInfoRepository;

class AdminWorkspaceService extends BaseService
{
    protected $memberRepository;
    public function __construct(WorkspaceInfoRepository $repository, MemberRepository $memberRepository)
    {
        $this->baseRepository = $repository;
        $this->memberRepository = $memberRepository;
    }

    public function changeRole(Request $request)
    {
        try {

            $role_id = $request->input('role_id');
            $member_id = $request->member_id;
            $role = LmsRole::findOrFail($role_id);
            $member = $this->memberRepository->find($member_id);
            DB::beginTransaction();
            $member->roles()->sync($role->id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function workspaceStatis(Request $request)
    {

        $count_classroom = ClassRoom::where('is_active', true)->count();
        $count_teacher = Member::whereHas('roles', function($query){
            $query->where('name', 'teacher');
        })->count();
        $count_student = Member::whereHas('roles', function($query){
            $query->where('name', 'student');
        })->count();
        $count_major = Major::where('is_active', true)->count();
        $count_subject = Subject::where('is_active', true)->count();
        $data = [
            'count_classroom' => $count_classroom,
            'count_teacher' => $count_teacher,
            'count_student' => $count_student,
            'count_major' => $count_major,
            'count_subject' => $count_subject
        ];
        return $data;
    }

    public function workspaceNotification(Request $request)
    {
        $data = Notification::with('member')
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $data;
    }

    public function workspaceEvent(Request $request)
    {
        $data = Event::where(['status' => 'PUBLISH'], ['start_date', '<', Carbon::now()], ['end_date', '>', Carbon::now()])
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        $data = $data->setCollection($data->getCollection()->map(function ($event) {
            $subject_ids = explode(',', $event->subject_ids);
            $classroom_ids = explode(',', $event->classroom_ids);
            $member_ids = explode(',', $event->member_ids);
            $event['subjects'] = Subject::whereIn('id', $subject_ids)->get();
            $event['classrooms'] = ClassRoom::whereIn('id', $classroom_ids)->get();
            $event['members'] = Member::whereIn('id', $member_ids)->get();
            return $event;
        }));
        return $data;
    }

    public function workspaceMember(Request $request)
    {
        $data = $this->memberRepository->with(['subjects', 'roles', 'schoolYears', 'classrooms'])
            ->orderBy($this->sort, $this->dir);

        if($request->get('outside-classes')){ // get all member outside $classroom_ids
            $classroom_ids = $request->get('outside-classes');
            $data = $data->whereHas('classrooms', function($query) use($classroom_ids){
                $query->whereNotIn('id', $classroom_ids);
            });
        }

        $data =  $data->paginate($this->limit);
        return $data;
    }

    public function workspaceClassroom(Request $request)
    {
        $data = ClassRoom::where('parent_id', 0)->with('children')->withCount('members')
            ->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $data;
    }

    public function workspaceTrainingProgram(Request $request)
    {
        $data = SchoolLevel::with(['majors', 'subjects', 'skills', 'topics'])
            ->withCount(['majors', 'subjects', 'skills', 'topics'])
            ->get();
        return $data;
    }

    public function detachTeamWork($id, Request $request)
    {
        try {
            $user_ids = $request->input('user_ids');
            $token = $request->header('Authorization');
            DB::beginTransaction();
            Member::whereIn('user_id', $user_ids)->delete();
            Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token
            ])->post(config('lms.service_url.auth')."/auth/api/v1/user/workspace-info/$id/members/detach-team", [
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
