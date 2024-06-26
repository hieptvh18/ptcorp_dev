<?php

namespace Modules\Lms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Lms\Http\Requests\Admin\SubjectSaveRequest;
use Modules\Lms\Services\Admin\AdminSubjectService;

/**
 * @group Module Lms
 *
 * APIs for managing subject
 *
 * @subgroup Quản lý môn học
 * @subgroupDescription AdminSubjectController
 */
class AdminSubjectController extends ApiController
{
    protected $service;

    public function __construct(AdminSubjectService $adminSubjectService)
    {
        $this->service = $adminSubjectService;
    }

    /**
     * Admin xem danh sách môn học
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->service->getList($request);
        return $this->json($item);
    }

    /**
     * Admin thêm mới môn học.
     * @param SubjectSaveRequest $request
     * @return Response
     */
    public function store(SubjectSaveRequest $request)
    {
        $item = $this->service->create($request);
        $data = [
            'message' => __('cms::message.subject.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xem chi tiết môn học.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->service->find($id);
        return $this->json(['data'=>$item]);
    }

    /**
     * Admin cập nhật môn học.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $item = $this->service->update($request,$id);
        $data = [
            'message' => __('cms::message.subject.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Admin xóa môn học.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->service->delete($id);
        $data = [
            'message' => __('cms::message.subject.delete_success'),
        ];
        return $this->json($data);
    }
}
