<?php

namespace Modules\Lms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Services\ClassroomService;
use Modules\Lms\Http\Requests\ClassRoomCreateRequest;
use Modules\Lms\Http\Requests\ClassRoomUpdateRequest;
use Modules\Lms\Http\Requests\DeleteClassRoomRequest;
use Modules\Lms\Services\Admin\AdminClassroomService;

/**
 * @group Module Lms
 *
 * APIs for managing classroom
 *
 * @subgroup Workspace classroom
 * @subgroupDescription ClassRoomController
 */
class AdminClassRoomController extends ApiController
{
    protected $classroomService;

    public function __construct(AdminClassroomService $classroomService)
    {
        $this->classroomService = $classroomService;
    }

    /**
     * Search
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function searchClassroom(Request $request)
    {
        $data = $this->classroomService->searchClassroom($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Thêm classroom
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function saveClassroom(ClassRoomCreateRequest $request)
    {
        $item = $this->classroomService->saveClassroom($request);
        $data = [
            'message' => __('lms::message.classroom.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa nhóm
     *
     * Remove the specified resource from storage.
     * @param Request $request
     * @return Response
     */
    public function deleteClassroom(DeleteClassRoomRequest $request)
    {
        $item = $this->classroomService->deleteClassroom($request);
        $data = [
            'message' => __('lms::message.classroom.delete_success'),
            'data' => $item
        ];
        return $this->json($data);

    }

    /**
     * Ghi chú nhóm
     *
     * update the specified resource from storage.
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function noteClassroom($classroom_id, Request $request)
    {
        $item = $this->classroomService->noteClassroom($classroom_id, $request);
        $data = [
            'message' => __('lms::message.classroom.note_success'),
            'data' => $item
        ];
        return $this->json($data);

    }

    /**
     * Chỉnh sửa classroom
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function updateClassroom(ClassRoomUpdateRequest $request, $id)
    {
        $item = $this->classroomService->updateClassroom( $request, $id);
        $data = [
            'message' => __('lms::message.classroom.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }
}
