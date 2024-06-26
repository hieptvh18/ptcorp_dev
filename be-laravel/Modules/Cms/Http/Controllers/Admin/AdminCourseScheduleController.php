<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CourseScheduleRequest;

/**
 * @group Module Cms
 *
 * APIs for managing course schedule
 *
 * @subgroup Cms Course Schedule
 * @subgroupDescription AdminCourseScheduleController
 */
class AdminCourseScheduleController extends ApiController
{
    /**
     * @var \Modules\Cms\Services\Admin\AdminCourseScheduleService
     */
    protected $cmsBaseService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminCourseScheduleService $adminCourseScheduleService,
    )
    {
        $this->cmsBaseService = $adminCourseScheduleService;
    }

    /**
     * Admin xem danh sách lịch dự kiến bắt đầu của 1 khóa học
     * @return Response
     */
    public function findScheduleByCourseId($courseId)
    {
        $data = $this->cmsBaseService->findScheduleByCourseId($courseId);
        return $this->json($data);
    }

    /**
     * Admin lưu lịch dự kiến
     * @param Request $request
     * @return Response
     */
    public function store(CourseScheduleRequest $request)
    {
        $item = $this->cmsBaseService->create($request);
        $data = [
            'message' => __('cms::message.course_schedule.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xem chi tiết lịch dự kiến
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsBaseService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin cập nhật lịch dự kiến
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CourseScheduleRequest $request, $id)
    {
        $item = $this->cmsBaseService->update($request,$id);
        $data = [
            'message' => __('cms::message.course_schedule.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa lịch dự kiến
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->cmsBaseService->delete($id);
        $data = [
            'message' => __("cms::message.course_schedule.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
