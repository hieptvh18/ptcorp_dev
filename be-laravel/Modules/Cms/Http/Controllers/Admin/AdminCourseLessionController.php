<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CmsCourseLessionRequest;

/**
 * @group Module Cms
 *
 * APIs for quản lý bài học
 *
 * @subgroup Cms Cousre Section Lession
 * @subgroupDescription AdminCourseLessionController
 */
class AdminCourseLessionController extends ApiController
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Services\Admin\AdminCourseLessionService $sectionRepository)
    {
        $this->baseRepository = $sectionRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Admin show danh sách bài học của phần học
     * @param int $id
     * @return Response
     */
    public function findLessonsByCourseId($courseId,$sectionId){
        $item = $this->baseRepository->findLessons($courseId,$sectionId);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Thêm mới bài học
     * @param Request $request
     * @return Response
     */
    public function store(CmsCourseLessionRequest $request)
    {
        $item = $this->baseRepository->create($request);
        $data = [
            'message' => __('cms::message.course_lesson.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xem chi tiết bài học
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->baseRepository->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin cập nhật bài học
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CmsCourseLessionRequest $request, $id)
    {
        $item = $this->baseRepository->update($request,$id);
        $data = [
            'message' => __('cms::message.course_lesson.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa bài học
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->baseRepository->delete($id);
        $data = [
            'message' => __('cms::message.course_lesson.delete_success'),
            'data' => $item
        ];
        return $this->json($data);
    }
}
