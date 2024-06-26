<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CourseLearn.
 *
 * @package namespace Modules\Cms\Models;
 */
class CourseLearn extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes;

    protected $table =  'lms_course_learns';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['course_id','name','is_active'];

    protected $casts = ['is_active' => 'boolean'];

}
