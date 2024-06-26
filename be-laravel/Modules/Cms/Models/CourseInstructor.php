<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cms\Traits\HasFilterCourse;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CourseInstructor.
 *
 * @package namespace Modules\Cms\Models;
 */
class CourseInstructor extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes, HasFilterCourse;

    protected $table = 'lms_course_instructors';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'avatar_url',
        'description'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'lms_course_instructor_map', 'instructor_id', 'course_id');
    }
}
