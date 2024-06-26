<?php

namespace Modules\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Models\CmsBlogTag;
use App\Http\Controllers\ApiController;
use Modules\Cms\Http\Requests\Admin\CmsBlogTagCreateRequest;
use Modules\Cms\Http\Requests\Admin\CmsBlogTagUpdateRequest;
use Modules\Cms\Services\Admin\AdminCmsBlogTagService;

/**
 * @group Module Cms
 *
 * APIs for managing cms blog tag
 *
 * @subgroup Cms Blog Tag
 * @subgroupDescription AdminCmsBlogTagController
 */
class AdminCmsBlogTagController extends ApiController
{
    protected $adminCmsBlogTagService;
    public function __construct(AdminCmsBlogTagService $adminCmsBlogTagService)
    {
        $this->adminCmsBlogTagService = $adminCmsBlogTagService;
    }

    /**
     * Danh sách blog tag
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->adminCmsBlogTagService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Thêm mới blog tag
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CmsBlogTagCreateRequest $request)
    {
        $item = $this->adminCmsBlogTagService->create($request);
        $data = [
            'message' => __('cms::message.cms_blog_tag.create_success'),
            'data' => $item
        ];

        return $this->json($data);
    }

    /**
     * chi tiết blog tag
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->adminCmsBlogTagService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Chỉnh sửa blog
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CmsBlogTagUpdateRequest $request, $id)
    {
        $updated = $this->adminCmsBlogTagService->update($request, $id);
        $data = [
            'message' => __('cms::message.cms_blog_tag.update_success'),
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Xóa blog
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->adminCmsBlogTagService->delete($id);
        $data = [
            'message' => __('cms::message.cms_blog_tag.delete_success'),
        ];
        return $this->json($data);
    }
}
