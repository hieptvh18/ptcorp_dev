<?php

namespace Modules\Cms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Cms\Http\Requests\UploadRequest;
use Modules\Cms\Services\UploadService;

/**
 * @group Module Cms
 *
 * APIs for managing endpoint cms
 *
 * @subgroup CMS Upload Management
 * @subgroupDescription UploadController
 */
class UploadController extends ApiController
{
    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * cms upload
     *
     * Upload new file to s3(param type = CMS_BANNER,CMS_FEEDBACK_STUDENT_AVATAR,CMS_CATEGORY_THUMBNAIL,CMS_FAQ_CATEGORY_THUMBNAIL,CMS_INSTRUCTOR_AVATAR).
     * @param Request $request
     * @return Response
     */
    public function uploadFile(UploadRequest $request)
    {
        $file = $this->uploadService->upload($request);
        return $this->json([
            'succes' => true,
            'file' => $file
        ]);
    }
}
