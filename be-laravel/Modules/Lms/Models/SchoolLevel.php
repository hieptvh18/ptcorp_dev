<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasAlias;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class SchoolLevel.
 *
 * @package namespace Modules\Lms\Models;
 */
class SchoolLevel extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes, CoreHasAlias, CoreHasUniqueCode;

    protected $table = "lms_school_levels";
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
        'description',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'lms_major_school_level_map', 'school_level_id', 'major_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'lms_subject_school_level_map', 'school_level_id', 'subject_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'lms_skill_school_level_map', 'school_level_id', 'skill_id');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'lms_topic_school_level_map', 'school_level_id', 'topic_id');
    }

}
