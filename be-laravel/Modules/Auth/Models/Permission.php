<?php

namespace Modules\Auth\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\Permission\Models\Permission as ModelsPermission;

/**
 * Class Permission.
 *
 * @package namespace Modules\Auth\Models;
 */
class Permission extends ModelsPermission implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    public function withChildPermissions()
    {
        $this->append('child_permissions');
        return $this;
    }

    public function childPermissions(): Attribute
    {
        return new Attribute(
            get: function () {
                $parent_id = $this->attributes['id'];
                $permissions = Permission::where('parent_id', $parent_id)->get();

                return $permissions;
            }
        );
    }

}
