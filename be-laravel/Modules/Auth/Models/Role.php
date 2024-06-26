<?php

namespace Modules\Auth\Models;

use Prettus\Repository\Contracts\Transformable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Lms\Models\Member;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Permission\Models\Role as ModelsRole;

/**
 * Class Role.
 *
 * @package namespace Modules\Auth\Models;
 */
class Role extends ModelsRole implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            config('permission.table_names.role_has_permissions'),
            'role_id',
            'permission_id'
        );
    }

    public function lmsMembers()
    {
        return $this->belongsToMany(Member::class, 'lms_member_role_map', 'role_id', 'member_id');
    }
}
