<?php

namespace Modules\Auth\Services;

use Illuminate\Http\Request;
use App\Services\BaseService;
use App\Exceptions\ApiException;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Models\Permission;
use Modules\Auth\Repositories\PermissionRepository;

class PermissionService extends BaseService
{

    public function __construct(PermissionRepository $repository)
    {
        $this->baseRepository = $repository;
    }

    public function getList(Request $request)
    {
        $this->limit = request()->query('size') ?? 12;
        $is_add_role = request()->query('is_add_role');
        $collection = $this->baseRepository
            ->with('children')
            ->where('parent_id', 0);
        if ($is_add_role == 'true') {
            $collection = $collection->with(['children' => function ($query) {
                $query->where('is_active', true);
            }]);
        }
        $collection = $collection->orderBy($this->sort, $this->dir)
            ->paginate($this->limit);
        return $collection;
    }

    public function find($id)
    {
        $item = Permission::find($id)->withChildPermissions();
        return $item;
    }

    public function saveGroupPermission(Request $request)
    {
        try {
            $child_permissions = $request->child_permissions;
            DB::beginTransaction();
            $data = $request->only(['name', 'label', 'bizapp_alias', 'is_active']);
            $permission = $this->baseRepository->updateOrCreate(
                ['id' => $request->id ?? null],
                [
                    'name' => $data['name'],
                    'label' => $data['label'],
                    'bizapp_alias' => $data['bizapp_alias'],
                    'is_active' => $data['is_active']
                ]
            );

            foreach ($child_permissions as $child_permission) {
                $this->baseRepository->updateOrCreate(
                    ['id' => $child_permission['id'] ?? null],
                    [
                        'name' => $child_permission['name'],
                        'label' => $child_permission['label'],
                        'bizapp_alias' => $permission->bizapp_alias,
                        'parent_id' => $permission->id,
                        'is_active' => $child_permission['is_active']
                    ]
                );
            }
            DB::commit();
            return true;
        } catch (ApiException $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
