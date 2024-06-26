<?php

namespace Modules\Cms\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 * @group Module Cms
 *
 * APIs for managing cms banner
 *
 * @subgroup Cms Banner
 * @subgroupDescription CmsBannerController
 */
class CmsBannerController extends ApiController
{
    /**
     * @var \Modules\Cms\Services\Public\CmsBannerService
     */
    protected $cmsBannerService;

    public function __construct(
        \Modules\Cms\Services\Public\CmsBannerService $adminCmsBannerService,
    )
    {
        $this->middleware(['workspace_db']);
        $this->cmsBannerService = $adminCmsBannerService;
    }

    /**
     * Lấy danh sách banner đang publish.
     * @return Response
     */
    public function getListBannerPublish(Request $request)
    {
        $item = $this->cmsBannerService->getListBannerPublish($request);
        $data = [
            'message' => __('cms::message.banner.get_list_publish_success'),
            'data' => $item
        ];
        return $this->json($data);
    }
}
