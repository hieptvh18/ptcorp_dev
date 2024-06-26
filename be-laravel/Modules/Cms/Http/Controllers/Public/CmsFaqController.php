<?php

namespace Modules\Cms\Http\Controllers\Public;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Public\CmsFaqRequest;

/**
 * @group Module Cms
 *
 * APIs public for faq
 *
 * @subgroup Cms Faq
 * @subgroupDescription CmsFaqController
 */
class CmsFaqController extends ApiController
{
    protected $faqService;

    public function __construct(\Modules\Cms\Services\Public\CmsFaqService $faqService)
    {
        $this->middleware(['workspace_db']);
        $this->faqService = $faqService;
    }

    /**
     * Danh sách faq public
     * @return Response
     */
    public function index(CmsFaqRequest $request)
    {
        $courses = $this->faqService->getList($request);
        return $this->json($courses);
    }
}
