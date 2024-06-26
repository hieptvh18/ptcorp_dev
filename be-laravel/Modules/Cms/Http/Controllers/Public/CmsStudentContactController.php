<?php

namespace Modules\Cms\Http\Controllers\Public;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cms\Http\Requests\Public\CmsStudentContactCreateRequest;

/**
 * @group Module Cms
 *
 * APIs for student contact
 *
 * @subgroup Cms Contact
 * @subgroupDescription CmsStudentContactController
 */
class CmsStudentContactController extends ApiController
{
    protected $studentContactService;

    public function __construct(\Modules\Cms\Services\Public\StudentContactService $studentContactService)
    {
        $this->middleware(['workspace_db']);
        $this->studentContactService = $studentContactService;
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
     * Học viên tạo mới đăng ký tư vấn
     * @param Request $request
     * @return Response
     */
    public function store(CmsStudentContactCreateRequest $request)
    {
        $item = $this->studentContactService->create($request);
        $data = [
            'message' => __('cms::message.contact.create_success'),
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
