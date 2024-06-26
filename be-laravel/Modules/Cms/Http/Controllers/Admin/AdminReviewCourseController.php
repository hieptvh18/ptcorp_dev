<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CmsReviewSaveRequest;

/**
 * @group Module Cms
 *
 * APIs for admin quản lý đánh giá khóa học
 *
 * @subgroup Cms Admin Review
 * @subgroupDescription AdminReviewCourseController
 */
class AdminReviewCourseController extends ApiController
{
    protected $courseReviewService;

    public function __construct(\Modules\Cms\Services\Admin\AdminCourseReviewService $courseReviewService)
    {
        $this->courseReviewService = $courseReviewService;
    }

    /**
     * Admin xem danh sách đánh giá khóa học
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data = $this->courseReviewService->getListReview($request);
        return $this->json($data);
    }

    /**
     * Admin tạo mới đánh giá khóa học
     * @param Request $request
     * @return Renderable
     */
    public function store(CmsReviewSaveRequest $request)
    {
        $item = $this->courseReviewService->createReview($request);
        $data = [
            'message' => __('cms::message.course_review.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xem chi tiết đánh giá khóa học.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = $this->courseReviewService->getReviewById($id);
        return $this->json($data);
    }

    /**
     * Admin cập nhật đánh giá khóa học
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CmsReviewSaveRequest $request, $id)
    {
        $item = $this->courseReviewService->updateReview($request,$id);
        $data = [
            'message' => __('cms::message.course_review.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa đánh giá khóa học.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $item = $this->courseReviewService->delete($id);
        $data = [
            'message' => __('cms::message.course_review.delete_success'),
        ];
        return $this->json($data);
    }
}
