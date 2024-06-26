<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CmsFaqCategoryCreateRequest;
use Modules\Cms\Http\Requests\Admin\CmsFaqCategoryUpdateRequest;

/**
 * @group Module Cms
 *
 * APIs for managing cms faq category
 *
 * @subgroup Cms faq category
 * @subgroupDescription AdminFaqCategoryController
 */
class AdminFaqCategoryController extends ApiController
{

    protected $cmsFaqCategoryService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminFaqCategoryService $adminCmsFaqCategoryService,
    )
    {
        $this->cmsFaqCategoryService = $adminCmsFaqCategoryService;
    }

    /**
     * Danh sách danh mục faq
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsFaqCategoryService->getList($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Tạo mới danh mục faq
     * @param Request $request
     * @return Response
     */
    public function store(CmsFaqCategoryCreateRequest $request)
    {
        $item = $this->cmsFaqCategoryService->create($request);
        $data = [
            'message' => __('cms::message.faq_category.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết danh mục faq
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsFaqCategoryService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Cập nhật danh mục faq
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CmsFaqCategoryUpdateRequest $request, $id)
    {
        $item = $this->cmsFaqCategoryService->update($request,$id);
        $data = [
            'message' => __('cms::message.faq_category.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa danh mục faq
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->cmsFaqCategoryService->delete($id);
        $data = [
            'message' => __("cms::message.faq_category.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
