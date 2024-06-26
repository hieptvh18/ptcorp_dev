<?php

namespace Modules\Cms\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Cms\Http\Requests\Admin\CourseLanguageRequest;

/**
 * @group Module Cms
 *
 * APIs for managing course language
 *
 * @subgroup Cms Course Lang
 * @subgroupDescription AdminCourseLanguageController
 */
class AdminCourseLanguageController extends ApiController
{
    protected $courseLanguageService;

    public function __construct(\Modules\Cms\Services\Admin\AdminCourseLanguageService $courseLanguageService)
    {
        $this->courseLanguageService = $courseLanguageService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = $this->courseLanguageService->getAll();
        return $this->json($data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CourseLanguageRequest $request)
    {
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CourseLanguageRequest $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
    }
}
