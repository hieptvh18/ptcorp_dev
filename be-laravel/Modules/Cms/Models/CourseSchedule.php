<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CourseSchedule.
 *
 * @package namespace Modules\Cms\Models;
 */

class CourseSchedule extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes;

    protected $table = 'lms_course_schedules';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'start_date',
        'end_date',
        'schedule_days',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];
}
