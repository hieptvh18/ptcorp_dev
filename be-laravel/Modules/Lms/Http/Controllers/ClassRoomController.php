<?php

namespace Modules\Lms\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Http\Requests\ClassRoomCreateRequest;
use Modules\Lms\Services\ClassroomService;

/**
 * @group Module Lms
 *
 * APIs for managing classroom
 *
 * @subgroup Workspace classroom
 * @subgroupDescription ClassRoomController
 */
class ClassRoomController extends ApiController
{
    protected $classroomService;

    public function __construct(ClassroomService $classroomService)
    {
        $this->classroomService = $classroomService;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Thêm classroom
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function saveClassroom(ClassRoomCreateRequest $request)
    {
        $item = $this->classroomService->saveClassroom($request);
        $data = [
            'message' => __('auth::message.classroom.create_success'),
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
