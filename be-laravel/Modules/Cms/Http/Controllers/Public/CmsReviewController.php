<?php

namespace Modules\Cms\Http\Controllers\Public;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Public\CmsFeedbackCreateRequest;

/**
 * @group Module Cms
 *
 * APIs for student review
 *
 * @subgroup Cms Review
 * @subgroupDescription CmsReviewController
 */
class CmsReviewController extends ApiController
{
    protected $reviewService;

    public function __construct(\Modules\Cms\Services\Public\CmsReviewService $reviewService)
    {
        $this->middleware(['workspace_db']);
        $this->reviewService = $reviewService;
    }

    /**
     * Danh sách reviews
     * @return Response
     */
    public function index(Request $request, $courseId)
    {
        $data = $this->reviewService->getCourseReview($request, $courseId);
        return $this->json(['data' => $data]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function store(CmsFeedbackCreateRequest $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
