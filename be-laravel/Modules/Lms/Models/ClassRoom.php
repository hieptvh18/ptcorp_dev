<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class ClassRoom.
 *
 * @package namespace Modules\Lms\Models;
 */
class ClassRoom extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes;

    protected $table = "lms_classrooms";
    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'alias',
        'parent_id',
        'type',
        'is_active',
        'status',
        'note'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'lms_member_classroom', 'classroom_id', 'member_id');
    }

    public function children()
    {
        return $this->hasMany(ClassRoom::class, 'parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(ClassRoom::class, 'parent_id');
    }

    public function notificationConfigMode()
    {
        return $this->morphMany(NotificationConfigMode::class, 'notificationable','notification_typeable','notification_typeable_id');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class,'school_year_id');
    }
}
