<?php

namespace Modules\Lms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Services\Admin\AdminMemberService;
use Modules\Lms\Http\Requests\MoveClassRoomRequest;
use Modules\Lms\Http\Requests\AssignClassRoomRequest;
use Modules\Lms\Http\Requests\MemberCreateRequest;
use Modules\Lms\Http\Requests\RemoveFromClassroomRequest;

/**
 * @group Module Lms
 *
 * APIs for managing admin member
 *
 * @subgroup member admin
 * @subgroupDescription AdminMemberController
 */
class AdminMemberController extends ApiController
{
    protected $memberService;

    public function __construct(AdminMemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    /**
     * Thêm thành viên vào nhóm lớp học
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function assignClassroom(AssignClassRoomRequest $request)
    {
        $data = $this->memberService->assignClassroom($request);
        return $this->json(['success' => $data]);
    }

    /**
     * Di chuyển thành viên sang nhóm khác
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function moveClassroom(MoveClassRoomRequest $request)
    {
        $item = $this->memberService->moveClassroom($request);
        $data = [
            'message' => __('lms::message.member.move_classroom_success'),
            'data' => $item
        ];
        return $this->json(['success' => $data]);
    }

    /**
     * Thêm mới thành viên
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function createMember(MemberCreateRequest $request)
    {
        $item = $this->memberService->createMember($request);
        $data = [
            'message' => __('lms::message.member.create_success'),
            'data' => $item
        ];
        return $this->json(['data' => $data]);
    }

    /**
     * Xóa thành viên khỏi nhóm
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function removeFromClassroom(RemoveFromClassroomRequest $request)
    {
        $item = $this->memberService->removeFromClassroom($request);
        $data = [
            'message' => __('lms::message.member.remove_from_classroom_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * chi tiết thành viên
     *
     * Store a newly created resource in storage.
     * @param int $member_id
     * @return Response
     */
    public function findMember($member_id)
    {
        $data = $this->memberService->findMember($member_id);
        return $this->json(['data' => $data]);
    }
}
