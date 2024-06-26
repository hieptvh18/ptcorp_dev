<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Admin\CourseLearnRequest;

/**
 * @group Module Cms
 *
 * APIs for quản lý What you'll learn
 *
 * @subgroup Cms Cousre Learn
 * @subgroupDescription CourseLearnController
 */
class AdminCourseLearnController extends ApiController
{
    protected $courseLearnService;

    public function __construct(\Modules\Cms\Services\Admin\AdminCourseLearnService $courseLearnService)
    {
        $this->courseLearnService = $courseLearnService;
    }

    /**
     * Admin xem danh course learn
     * @return Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Admin xem danh sách học được của 1 khóa học
     * @return Response
     */
    public function findLearnsByCourseId($courseId)
    {
        $data = $this->courseLearnService->findLearnsByCourseId($courseId);
        return $this->json($data);
    }

    /**
     *  Admin tạo mới và cập nhật course learn
     * @param Request $request
     * @return Response
     */
    public function save($courseId,CourseLearnRequest $request)
    {
        $item = $this->courseLearnService->save($courseId,$request);
        $data = [
            'message' => __('cms::message.course_learn.save_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin show chi tiết course learn
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->courseLearnService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CourseLearnRequest $request, $id)
    {
        //
    }

    /**
     * Admin xóa course learn
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->courseLearnService->delete($id);
        $data = [
            'message' => __('cms::message.course_learn.delete_success'),
            'data' => $item
        ];
        return $this->json($data);
    }
}
