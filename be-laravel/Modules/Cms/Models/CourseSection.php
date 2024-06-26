<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CourseSection.
 *
 * @package namespace Modules\Cms\Models;
 */
class CourseSection extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes;

    protected $table = 'lms_course_sections';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'name',
        'total_duration_lesson',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function lessons(){
        return $this->hasMany(CourseLession::class,'section_id');
    }

    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
}
