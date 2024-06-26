<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Admin\CourseRequirementRequest;

/**
 * @group Module Cms
 *
 * APIs for quản lý requirements
 *
 * @subgroup Cms Cousre requirements
 * @subgroupDescription CourseRequirementController
 */
class AdminCourseRequirementController extends ApiController
{
    protected $courseRequirementService;

    public function __construct(\Modules\Cms\Services\Admin\AdminCourseRequirementService $courseRequirementService)
    {
        $this->courseRequirementService = $courseRequirementService;
    }

    /**
     * Admin xem danh sách requirement
     * @return Response
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Admin xem danh sách yêu cầu của 1 khóa học
     * @return Response
     */
    public function findRequirementsByCourseId($courseId)
    {
        $data = $this->courseRequirementService->findRequirementsByCourseId($courseId);
        return $this->json($data);
    }

    /**
     *  Admin tạo mới và cập nhật requirement
     * @param Request $request
     * @return Response
     */
    public function save($courseId,CourseRequirementRequest $request)
    {
        $item = $this->courseRequirementService->save($courseId,$request);
        $data = [
            'message' => __('cms::message.course_requirement.save_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin show chi tiết requirement
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->courseRequirementService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin cập nhật requirement
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CourseRequirementRequest $request, $id)
    {
        //
    }

    /**
     * Admin xóa requirement
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->courseRequirementService->delete($id);
        $data = [
            'message' => __('cms::message.course_requirement.delete_success'),
            'data' => $item
        ];
        return $this->json($data);
    }
}
