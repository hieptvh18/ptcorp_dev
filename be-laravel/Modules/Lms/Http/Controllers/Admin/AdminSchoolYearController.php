<?php

namespace Modules\Lms\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Lms\Http\Requests\SchoolYearCreateRequest;
use Modules\Lms\Http\Requests\SchoolYearUpdateRequest;
use Modules\Lms\Services\Admin\AdminSchoolYearService;

/**
 * @group Module Lms
 *
 * APIs for managing admin school year
 *
 * @subgroup admin school year
 * @subgroupDescription AdminSchoolYearController
 */
class AdminSchoolYearController extends ApiController
{
    protected $schoolYearService;

    public function __construct(AdminSchoolYearService $schoolYearService)
    {
        $this->schoolYearService = $schoolYearService;
    }

    /**
     * Danh sách niên khóa
     *
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->schoolYearService->getList($request);
        return $this->json($data, 200);
    }

    /**
     * Thêm mới niên khóa
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(SchoolYearCreateRequest $request)
    {
        $created = $this->schoolYearService->create($request);
        $data = [
            'message' => __('lms::message.school_year.create_success'),
            'data' => $created
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết liên khóa
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->schoolYearService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Chỉnh sửa niên khóa
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(SchoolYearUpdateRequest $request, $id)
    {
        $updated = $this->schoolYearService->update($request, $id);
        $data = [
            'message' => __('lms::message.school_year.update_success'),
            'data' => $updated
        ];
        return $this->json($data);
    }

    /**
     * Xóa niên khóa
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $deleted = $this->schoolYearService->delete($id);
        $data = [
            'message' => __('lms::message.school_year.delete_success'),
        ];
        return $this->json($data);
    }
}
