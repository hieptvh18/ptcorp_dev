<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CourseUpdateRequest;
use Modules\Cms\Http\Requests\Admin\CourseCreateRequest;

/**
 * @group Module Cms
 *
 * APIs for managing cms course
 *
 * @subgroup Cms Cousre
 * @subgroupDescription AdminCmsCourseController
 */
class AdminCmsCourseController extends ApiController
{
    protected $cmsCourseService;

    public function __construct(\Modules\Cms\Services\Admin\AdminCourseService $adminCourseService)
    {
        $this->cmsCourseService = $adminCourseService;
    }

    /**
     * Admin xem danh sách khóa học
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsCourseService->getList($request);
        $data = [
            'message' => __('cms::message.course.get_list_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     *  Admin tạo mới khóa học
     * @param Request $request
     * @return Response
     */
    public function store(CourseCreateRequest $request)
    {
        $item = $this->cmsCourseService->create($request);
        $data = [
            'message' => __('cms::message.course.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin show chi tiết khóa học
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsCourseService->find($id);
        $data = [
            'message' => __('cms::message.course.get_course_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin cập nhật khóa học
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CourseUpdateRequest $request, $id)
    {
        $item = $this->cmsCourseService->update($request,$id);
        $data = [
            'message' => __('cms::message.course.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa khóa học
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->cmsCourseService->delete($id);
        $data = [
            'message' => __('cms::message.course.delete_success'),
            'data' => $item
        ];
        return $this->json($data);
    }
}
