<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CourseLession.
 *
 * @package namespace Modules\Cms\Models;
 */
class CourseLession extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes;

    protected $table = 'lms_course_section_lessons';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'section_id',
        'name',
        'description',
        'preview_video_url',
        'duration',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function section(){
        return $this->belongsTo(CourseSection::class,'section_id');
    }

}
