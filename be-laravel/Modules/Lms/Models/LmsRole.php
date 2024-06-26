<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class LmsRole.
 *
 * @package namespace Modules\Lms\Models;
 */
class LmsRole extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "lms_roles";
    protected $connection = 'workspace_db';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'guard_name',
        'label',
        'bizapp_alias',
        'is_active'
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'lms_member_role_map', 'role_id', 'member_id');
    }

}
