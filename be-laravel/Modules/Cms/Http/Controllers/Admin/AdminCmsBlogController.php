<?php

namespace Modules\Cms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Cms\Http\Requests\Admin\CmsBlogCreateRequest;
use Modules\Cms\Http\Requests\Admin\CmsBlogUpdateRequest;
use Modules\Cms\Services\Admin\AdminCmsBlogService;

/**
 * @group Module Cms
 *
 * APIs for managing cms blog
 *
 * @subgroup Cms Blog
 * @subgroupDescription AdminCmsBlogController
 */
class AdminCmsBlogController extends ApiController
{
    protected $adminCmsBlogService;
    public function __construct(AdminCmsBlogService $adminCmsBlogService)
    {
        $this->adminCmsBlogService = $adminCmsBlogService;
    }

    /**
     * Danh sách blog
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->adminCmsBlogService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Thêm mới blog
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CmsBlogCreateRequest $request)
    {
        $item = $this->adminCmsBlogService->create($request);
        $data = [
            'message' => __('cms::message.cms_blog.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * chi tiết blog
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->adminCmsBlogService->find($id)->load(['categories', 'tags']);
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
    public function update(CmsBlogUpdateRequest $request, $id)
    {
        $updated = $this->adminCmsBlogService->update($request, $id);
        $data = [
            'message' => __('cms::message.cms_blog.update_success'),
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
        $deleted = $this->adminCmsBlogService->delete($id);
        $data = [
            'message' => __('cms::message.cms_blog.delete_success'),
        ];
        return $this->json($data);
    }
}
