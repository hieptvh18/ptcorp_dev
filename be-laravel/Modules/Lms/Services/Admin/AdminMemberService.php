<?php

namespace Modules\Lms\Services\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Modules\Lms\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Modules\Lms\Repositories\MemberRepository;
use Modules\Auth\Notifications\RegisterAccountNotification;
use Modules\Lms\Events\EventAdminMemberServiceCreateMemberAfter;
use Modules\Lms\Models\ClassRoom;

class AdminMemberService extends BaseService
{
    protected $memberRepository;
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function assignClassroom(Request $request)
    {
        try {
            $member_id = $request->member_id;
            $class_room_ids = $request->class_room_ids;
            $member = $this->memberRepository->find($member_id);
            DB::beginTransaction();
            $member->classrooms()->syncWithoutDetaching($class_room_ids);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function moveClassroom(Request $request)
    {
        try {
            $member_id = $request->input('member_id');
            $member = $this->memberRepository->find($member_id);
            $old_classroom_id = $request->input('old_classroom_id');
            $new_classroom_ids = $request->input('new_classroom_ids');
            DB::beginTransaction();
            $member->classrooms()->detach($old_classroom_id);
            $member->classrooms()->attach($new_classroom_ids);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createMember(Request $request)
    {
        try {
            $classroom_ids = $request->classroom_ids;
            $classroom_child_ids = ClassRoom::whereIn('id', $classroom_ids)->where('parent_id', '<>', 0)->pluck('id')->toArray();
            $classroom_parent_ids = ClassRoom::whereIn('id', $classroom_child_ids)->pluck('parent_id')->toArray();
            array_unique(array_merge($classroom_parent_ids, $classroom_ids));
            $role_id = $request->role_id;
            DB::beginTransaction();
            $item = $request->all();
            $member_check = $this->memberRepository->where('email', $item['email'])->first();
            if (!$member_check) {
                if ($item['type_show'] == 'AUTO_FILL') {
                    $arr = explode('@', $item['email']);
                    $user_name = array_shift($arr);
                    $item['firstname'] = $user_name;
                    $item['lastname'] = $user_name;
                    $item['mobile'] = '0988888888';

                }
                $member = $this->memberRepository->create($item);
                $member->classrooms()->attach($classroom_ids);
                $member->roles()->attach($role_id);
                DB::commit();
                $result = event(new EventAdminMemberServiceCreateMemberAfter($member));
                return $result[0];
            }
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function removeFromClassroom(Request $request)
    {
        try {
            $member_id = $request->member_id;
            $classroom_ids = $request->classroom_ids;
            $remove_classroom_ids = [];
            $member = $this->memberRepository->find($member_id);
            $classroom_parent_ids = ClassRoom::whereIn('id', $classroom_ids)->where('parent_id', 0)->pluck('id')->toArray();
            $remove_classroom_child_ids = ClassRoom::whereIn('parent_id', $classroom_parent_ids)->pluck('id')->toArray();
            $remove_classroom_ids = array_unique(array_merge($remove_classroom_child_ids, $remove_classroom_ids));
            $remove_classroom_ids = array_unique(array_merge($classroom_parent_ids, $remove_classroom_ids));
            DB::beginTransaction();
            $member->classrooms()->detach($remove_classroom_ids);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findMember($member_id){
        $member = $this->memberRepository->find($member_id)->load(['roles', 'classrooms', 'subjects', 'schoolYears']);
        return $member;
    }
}
