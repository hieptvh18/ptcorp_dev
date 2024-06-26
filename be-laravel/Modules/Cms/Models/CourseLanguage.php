<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cms\Traits\HasFilterCourse;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CourseLanguage.
 *
 * @package namespace Modules\Cms\Models;
 */
class CourseLanguage extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes, HasFilterCourse;

    protected $table =  'lms_course_languages';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'flag',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'lms_course_language_map', 'language_id', 'course_id');
    }
}
