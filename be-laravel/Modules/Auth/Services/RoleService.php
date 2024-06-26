<?php

namespace Modules\Auth\Services;

use Exception;
use Illuminate\Http\Request;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Models\Permission;
use Modules\Auth\Repositories\RoleRepository;

class RoleService extends BaseService
{

    public function __construct(RoleRepository $roleRepository)
    {
        $this->baseRepository = $roleRepository;
    }

    public function find($id)
    {
        $item = $this->baseRepository->find($id)->load(['permissions' => function($query){
            $query->where('parent_id', '<>', 0)->with('parent:id,name,label,is_active');
        }]);
        return $item;
    }

    public function create(Request $request)
    {
        try {
            $permission_ids = $request->input('permission_ids');

            DB::beginTransaction();
            $data = $request->all();
            $item = $this->baseRepository->create($data);
            $item->givePermissionTo($permission_ids);
            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if (in_array('update', $this->allowPolicies)) {
                $this->authorize('update', $id);
            }
            $permission_ids = $request->input('permission_ids');

            DB::beginTransaction();
            $data = $request->all();
            $item = $this->baseRepository->update($data, $id);
            $item->syncPermissions($permission_ids);

            DB::commit();
            return $item;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
