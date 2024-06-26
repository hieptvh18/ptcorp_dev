<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CmsCourseSectionRequest;

/**
 * @group Module Cms
 *
 * APIs for quản lý chương học
 *
 * @subgroup Cms Cousre Section
 * @subgroupDescription AdminCourseSectionController
 */
class AdminCourseSectionController extends ApiController
{
    protected $baseRepository;

    public function __construct(\Modules\Cms\Services\Admin\AdminCourseSectionService $sectionService)
    {
        $this->baseRepository = $sectionService;
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
     * Admin show danh sách chương học của 1 khóa học
     * @param int $id
     * @return Response
     */
    public function findSectionsByCourseId($courseId){
        $item = $this->baseRepository->findSections($courseId);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Thêm mới chương học
     * @param CmsCourseSectionRequest $request
     * @return Response
     */
    public function store(CmsCourseSectionRequest $request)
    {
        $item = $this->baseRepository->create($request);
        $data = [
            'message' => __('cms::message.course_section.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xem chi tiết chương học
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
     * Admin cập nhật chương học
     * @param CmsCourseSectionRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CmsCourseSectionRequest $request, $id)
    {
        $item = $this->baseRepository->update($request,$id);
        $data = [
            'message' => __('cms::message.course_section.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa chương học
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->baseRepository->delete($id);
        $data = [
            'message' => __('cms::message.course_section.delete_success'),
            'data' => $item
        ];
        return $this->json($data);
    }
}
