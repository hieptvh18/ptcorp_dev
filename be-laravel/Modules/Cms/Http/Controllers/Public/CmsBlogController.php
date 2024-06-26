<?php

namespace Modules\Cms\Http\Controllers\Public;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Services\Public\CmsBlogService;

/**
 * @group Module Cms
 *
 * APIs public for cms blog
 *
 * @subgroup Cms blog
 * @subgroupDescription CmsBlogController
 */
class CmsBlogController extends ApiController
{
    protected $blogService;

    public function __construct(CmsBlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    /**
     * Danh sách public tin tức
     *
     * @param Request $request
     * @return Response
     */
    public function getListBlog(Request $request)
    {
        $data = $this->blogService->getListBlog($request);
        return $this->json(['data' => $data]);
    }

    /**
     * Chi tiết tin tức
     *
     * Show the specified resource.
     * @param string $alias
     * @return Response
     */
    public function showBlogByAlias($alias)
    {
        $data = $this->blogService->findPublicBlog($alias);
        return $this->json(['data' => $data], 200);
    }

    /**
     * Danh sách tin tức liên quan
     *
     * Display a listing of the resource.
     * @param int $blog_id
     * @return Response
     */
    public function relatedBlog($blog_id)
    {
        $data = $this->blogService->getRelatedBlog($blog_id);
        return $this->json(['data' => $data], 200);
    }
}

