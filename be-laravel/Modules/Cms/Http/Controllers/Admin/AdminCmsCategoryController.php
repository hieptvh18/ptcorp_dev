<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Admin\CmsCategoryCreateRequest;
use Modules\Cms\Http\Requests\Admin\CmsCategoryUpdateRequest;

/**
 * @group Module Cms
 *
 * APIs for managing cousre categories
 *
 * @subgroup Cms Categories
 * @subgroupDescription AdminCmsCategoryController
 */
class AdminCmsCategoryController extends ApiController
{
    /**
     * @var \Modules\Cms\Services\Admin\AdminCmsCategoryService
     */
    protected $cmsCategoryService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminCmsCategoryService $cmsCategoryService,
    )
    {
        $this->cmsCategoryService = $cmsCategoryService;
    }

    /**
     * Danh sách danh mục khóa học
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsCategoryService->getList($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Tạo mới danh mục khóa học
     * @param Request $request
     * @return Response
     */
    public function store(CmsCategoryCreateRequest $request)
    {
        $item = $this->cmsCategoryService->create($request);
        $data = [
            'message' => __('cms::message.category.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Hiển thị chi tiết danh mục khóa học
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsCategoryService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Cập nhật danh mục khóa học
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CmsCategoryUpdateRequest $request, $id)
    {
        $item = $this->cmsCategoryService->update($request,$id);
        $data = [
            'message' => __('cms::message.category.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa danh mục
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $item = $this->cmsCategoryService->delete($id);
        $data = [
            'message' => __("cms::message.category.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
