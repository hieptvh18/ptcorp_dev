<?php

namespace Modules\Cms\Models;

use Modules\Core\Traits\CoreHasAlias;
use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Traits\HasFilterCourse;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasUniqueCode;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Codebyray\ReviewRateable\Contracts\ReviewRateable;
use Modules\Cms\Traits\ReviewRateable as ReviewRateableTrait;

/**
 * Class Course.
 *
 * @package namespace Modules\Cms\Models;
 */
class Course extends Model implements Transformable, ReviewRateable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes, CoreHasAlias, CoreHasUniqueCode, ReviewRateableTrait, HasFilterCourse;

    protected $connection = 'workspace_db';

    protected $table = 'lms_course';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'code',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'avatar_url',
        'preview_video_url',
        'preview_video_type',
        'total_duration',
        'type',
        'address',
        'status'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function sections(){
        return $this->hasMany(CourseSection::class,'course_id');
    }

    public function lessons(){
        return $this->hasManyThrough(CourseLession::class,CourseSection::class,'course_id','section_id');
    }

    public function categories(){
        return $this->belongsToMany(CmsCategory::class,'lms_course_category_map','course_id','category_id');
    }

    public function instructors(){
        return $this->belongsToMany(CourseInstructor::class,'lms_course_instructor_map','course_id','instructor_id');
    }

    public function levels(){
        return $this->belongsToMany(CourseLevel::class,'lms_course_school_level_map','course_id','course_level_id');
    }

    public function learns(){
        return $this->hasMany(CourseLearn::class,'course_id');
    }

    public function requirements(){
        return $this->hasMany(CourseRequirement::class,'course_id');
    }

    public function languages(){
        return $this->belongsToMany(CourseLanguage::class,'lms_course_language_map','course_id','language_id');
    }

    public function schedules(){
        return $this->hasOne(CourseSchedule::class,'course_id');
    }

    public function ratings(){
        return $this->morphMany(\Codebyray\ReviewRateable\Models\Rating::class,'reviewrateable');
    }
}
