<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CourseInstructorRequest;

/**
 * @group Module Cms
 *
 * APIs for managing Course Instructor
 *
 * @subgroup Cms Course Instructor
 * @subgroupDescription AdminCourseInstructorController
 */
class AdminCourseInstructorController extends ApiController
{
    protected $cmsInstructorService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminInstructorService $adminCmsInstructorService,
    )
    {
        $this->cmsInstructorService = $adminCmsInstructorService;
    }

    /**
     * Danh sách người hướng dẫn
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsInstructorService->getList($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Tạo mới người hướng dẫn
     * @param Request $request
     * @return Response
     */
    public function store(CourseInstructorRequest $request)
    {
        $item = $this->cmsInstructorService->create($request);
        $data = [
            'message' => __('cms::message.instructor.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết người hướng dẫn
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsInstructorService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Cập nhật người hướng dẫn
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CourseInstructorRequest $request, $id)
    {
        $item = $this->cmsInstructorService->update($request,$id);
        $data = [
            'message' => __('cms::message.instructor.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa người hướng dẫn
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->cmsInstructorService->delete($id);
        $data = [
            'message' => __("cms::message.instructor.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
