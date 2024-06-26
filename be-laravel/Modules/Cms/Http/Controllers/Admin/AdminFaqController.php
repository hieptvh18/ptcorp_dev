<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Admin\CmsFaqRequest;

/**
 * @group Module Cms
 *
 * APIs for managing cms faq
 *
 * @subgroup Cms faq
 * @subgroupDescription AdminFaqController
 */
class AdminFaqController extends ApiController
{
    protected $cmsFaqService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminFaqService $adminCmsFaqService,
    )
    {
        $this->cmsFaqService = $adminCmsFaqService;
    }

    /**
     * Danh sách faq
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsFaqService->getList($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Tạo mới faq
     * @param Request $request
     * @return Response
     */
    public function store(CmsFaqRequest $request)
    {
        $item = $this->cmsFaqService->create($request);
        $data = [
            'message' => __('cms::message.faq.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết faq
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsFaqService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Cập nhật faq
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CmsFaqRequest $request, $id)
    {
        $item = $this->cmsFaqService->update($request,$id);
        $data = [
            'message' => __('cms::message.faq.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa faq
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->cmsFaqService->delete($id);
        $data = [
            'message' => __("cms::message.faq.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
