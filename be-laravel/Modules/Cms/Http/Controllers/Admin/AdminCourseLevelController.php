<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CourseLevelRequest;

/**
 * @group Module Cms
 *
 * APIs for managing course level
 *
 * @subgroup Cms Course Level
 * @subgroupDescription AdminCourseLevelController
 */
class AdminCourseLevelController extends ApiController
{
    /**
     * @var \Modules\Cms\Services\Admin\AdminCourseLevelService
     */
    protected $cmsBaseService;

    public function __construct(
        \Modules\Cms\Services\Admin\AdminCourseLevelService $adminCourseLevelService,
    )
    {
        $this->cmsBaseService = $adminCourseLevelService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $item = $this->cmsBaseService->getList($request);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CourseLevelRequest $request)
    {
        $item = $this->cmsBaseService->create($request);
        $data = [
            'message' => __('cms::message.course_level.create_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $item = $this->cmsBaseService->find($id);
        $data = [
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CourseLevelRequest $request, $id)
    {
        $item = $this->cmsBaseService->update($request,$id);
        $data = [
            'message' => __('cms::message.course_level.update_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->cmsBaseService->delete($id);
        $data = [
            'message' => __("cms::message.course_level.delete_success"),
            'data' => $item
        ];
        return $this->json($data);
    }
}
