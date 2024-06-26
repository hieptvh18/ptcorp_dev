<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CmsStudentContactCreateRequest;

/**
 * @group Module Cms
 *
 * APIs for managing cms contact
 *
 * @subgroup Quản lý học viên đăng ký tư vấn
 * @subgroupDescription AdminCmsContactController
 */
class AdminCmsContactController extends ApiController
{

    protected $cmsContactService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminStudentContactService $cmsContactService,
    )
    {
        $this->cmsContactService = $cmsContactService;
    }

    /**
     * Admin xem danh sách đăng ký
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsContactService->getList($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin tạo mới học viên đăng ký tư vấn
     * @param Request $request
     * @return Response
     */
    public function store(CmsStudentContactCreateRequest $request)
    {
        $item = $this->cmsContactService->create($request);
        $data = [
            'message' => __('cms::message.contact.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xem chi tiết contact
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsContactService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa học viên đăng ký tư vấn
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->cmsContactService->delete($id);
        $data = [
            'message' => __("cms::message.contact.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
