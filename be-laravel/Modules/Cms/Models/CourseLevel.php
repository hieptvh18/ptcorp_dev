<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cms\Traits\HasFilterCourse;
use Modules\Core\Traits\CoreHasAlias;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CourseLevel.
 *
 * @package namespace Modules\Cms\Models;
 */
class CourseLevel extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes, CoreHasAlias, CoreHasUniqueCode, HasFilterCourse;

    protected $table = 'lms_cms_course_level';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'end_date',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'lms_course_school_level_map', 'course_level_id', 'course_id');
    }
}
