<?php

namespace Modules\Common\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Http\Controllers\ApiController;
use Modules\Common\Http\Requests\CountryCreateRequest;
use Modules\Common\Http\Requests\CountryUpdateRequest;
use Modules\Common\Services\Admin\CountryAdminService;


/**
 * @group Module Common
 * APIs for Common
 *
 * @subgroup Admin Quản lý Quốc gia
 * @subgroupDescription Class CountryAdminController.
 * @package namespace Modules\Common\Http\Controllers\Admin;
 */
class CountryAdminController extends ApiController
{
    protected $countryAdminService;
    public function __construct(CountryAdminService $countryAdminService)
    {
        $this->countryAdminService = $countryAdminService;
    }

    /**
     * Danh sách quốc gia
     *
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->countryAdminService->getList($request);
        return $this->json($data);
    }

    /**
     * Thêm quốc gia
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(CountryCreateRequest $request)
    {
        $item = $this->countryAdminService->create($request);
        $data = [
            'message' => __('common::message.country.create_success'),
            'data' => $item,
        ];
        return $this->json($data);
    }

    /**
     * Chi tiết quốc gia
     *
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $data = $this->countryAdminService->find($id);
        return $this->json(['data' => $data]);
    }

    /**
     * Chỉnh sửa quốc gia
     *
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(CountryUpdateRequest $request, $id)
    {
        $item = $this->countryAdminService->update($request, $id);
        $data = [
            'message' => __('common::message.country.updated_success'),
            'data' => $item
        ];
        return $this->json($data);
    }

    /**
     * Xóa quốc gia
     *
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $item = $this->countryAdminService->delete($id);
        $data = [
            'message' => __('common::message.country.deleted_success'),
            'deleted' => $item
        ];
        return $this->json($data);
    }
}
