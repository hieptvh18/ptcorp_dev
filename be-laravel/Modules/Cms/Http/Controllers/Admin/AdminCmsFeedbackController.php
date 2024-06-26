<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Admin\CmsFeedbackCreateRequest;
use Modules\Cms\Http\Requests\Admin\CmsFeedbackUpdateRequest;

/**
 * @group Module Cms
 *
 * APIs for managing cms feedbacks
 *
 * @subgroup Cms Feedback
 * @subgroupDescription AdminCmsFeedbackController
 */
class AdminCmsFeedbackController extends ApiController
{

    protected $cmsFeedbackService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminCmsFeedbackService $cmsFeedbackService,
    )
    {
        $this->cmsFeedbackService = $cmsFeedbackService;
    }

    /**
     * Danh sách feedback
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsFeedbackService->getList($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Tạo mới feedback
     * @param Request $request
     * @return Response
     */
    public function store(CmsFeedbackCreateRequest $request)
    {
        $item = $this->cmsFeedbackService->create($request);
        $data = [
            'message' => __('cms::message.feedback.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Hiển thị chi tiết feedback
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsFeedbackService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Cập nhật feedback
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CmsFeedbackUpdateRequest $request, $id)
    {
        $item = $this->cmsFeedbackService->update($request,$id);
        $data = [
            'message' => __('cms::message.feedback.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa feedback
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->cmsFeedbackService->delete($id);
        $data = [
            'message' => __("cms::message.feedback.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
