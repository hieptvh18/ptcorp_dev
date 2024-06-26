<?php

namespace Modules\Lms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Lms\Http\Requests\Admin\ExamRoomCreateRequest;
use Modules\Lms\Http\Requests\Admin\ExamRoomListingFilterRequest;
use Modules\Lms\Http\Requests\Admin\ExamRoomUpdateRequest;
use Modules\Lms\Services\Admin\AdminExamRoomService;

/**
 * @group Module Lms
 *
 * APIs for managing exam room
 *
 * @subgroup Lms Quản lý phòng thi
 * @subgroupDescription AdminExamRoomController
 */
class AdminExamRoomController extends ApiController
{
    protected $examRoomService;

    public function __construct(AdminExamRoomService $examRoomService)
    {
        $this->examRoomService = $examRoomService;
    }

    /**
     * Admin xem dánh phòng thi
     * @return Response
     */
    public function index(ExamRoomListingFilterRequest $request)
    {
        $item = $this->examRoomService->getList($request);
        return $this->json($item);
    }

    /**
     * Admin tạo mới phòng thi.
     * @param ExamRoomCreateRequest $request
     * @return Response
     */
    public function store(ExamRoomCreateRequest $request)
    {
        $item = $this->examRoomService->create($request);
        $data = [
            'message' => __('cms::message.exam_room.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xem chi tiết phòng thi.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->examRoomService->find($id);
        return $this->json(['data'=>$item]);
    }

    /**
     * Admin cập nhật phòng thi.
     * @param ExamRoomCreateRequest $request
     * @param int $id
     * @return Response
     */
    public function update(ExamRoomUpdateRequest $request, $id)
    {
        $item = $this->examRoomService->update($request, $id);
        $data = [
            'message' => __('cms::message.exam_room.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa phòng thi.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->examRoomService->delete($id);
        $data = [
            'message' => __('cms::message.exam_room.delete_success'),
        ];
        return $this->json($data);
    }

    /**
     * Admin lấy danh sách phòng thi theo ids.
     *
     * @param Request $request
     * @return Response
     */
    public function getExamRoomByIds(Request $request)
    {
        $data = $this->examRoomService->getExamRoomByIds($request);
        return $this->json($data);
    }
}
