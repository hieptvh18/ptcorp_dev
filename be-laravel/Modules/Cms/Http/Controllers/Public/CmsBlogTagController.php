<?php

namespace Modules\Cms\Http\Controllers\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\ApiController;
use Modules\Cms\Services\Public\CmsBlogTagService;

/**
 * @group Module Cms
 *
 * APIs public for cms blog tag
 *
 * @subgroup Cms blog tag
 * @subgroupDescription CmsBlogTagController
 */
class CmsBlogTagController extends ApiController
{
    protected $blogTagService;

    public function __construct(CmsBlogTagService $blogTagService)
    {
        $this->blogTagService = $blogTagService;
    }

    /**
     * Danh sách public tag
     *
     * @param Request $request
     * @return Response
     */
    public function getListTagAssignBlog(Request $request)
    {
        $data = $this->blogTagService->getListTagAssignBlog($request);
        return $this->json($data);
    }

}

