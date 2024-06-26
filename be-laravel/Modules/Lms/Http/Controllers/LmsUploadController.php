<?php

namespace Modules\Lms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Http\Requests\LmsUploadRequest;
use Modules\Lms\Services\LmsUploadService;

/**
 * @group Module Lms
 *
 * APIs for managing endpoint lms
 *
 * @subgroup LMS Upload Management
 * @subgroupDescription LmsUploadController
 */
class LmsUploadController extends ApiController
{
    protected $lmsUploadService;
    public function __construct(LmsUploadService $lmsUploadService)
    {
        $this->lmsUploadService = $lmsUploadService;
    }

    /**
     * lms upload
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function lmsUploadFile(LmsUploadRequest $request)
    {
        $file = $this->lmsUploadService->upload($request);
        return $this->json([
            'succes' => true,
            'file' => $file
        ]);
    }
}
