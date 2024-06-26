<?php

namespace Modules\Cms\Http\Controllers\Public;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Public\CmsFeedbackCreateRequest;

/**
 * @group Module Cms
 *
 * APIs for student feedback
 *
 * @subgroup Cms Feedback
 * @subgroupDescription CmsFeedbackController
 */
class CmsFeedbackController extends ApiController
{
    protected $feedbackService;

    public function __construct(\Modules\Cms\Services\Public\CmsFeedbackService $feedbackService)
    {
        $this->middleware(['workspace_db']);
        $this->feedbackService = $feedbackService;
    }

    /**
     * Danh sách feedback
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->feedbackService->getList($request);
        return $this->json($item);
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
