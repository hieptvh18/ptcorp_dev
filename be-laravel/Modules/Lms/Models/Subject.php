<?php

namespace Modules\Lms\Models;

use Modules\Core\Traits\CoreHasAlias;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasUniqueCode;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Subject.
 *
 * @package namespace Modules\Lms\Models;
 */
class Subject extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes, CoreHasAlias, CoreHasUniqueCode;

    protected $table = "lms_subjects";
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
        'avatar_url',
        'description',
        'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function schoolLevels()
    {
        return $this->belongsToMany(SchoolLevel::class, 'lms_subject_school_level_map', 'subject_id', 'school_level_id');
    }

    public function majors()
    {
        return $this->belongsToMany(Major::class, 'lms_major_subject_map', 'subject_id', 'major_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Member::class, 'lms_teacher_subject', 'subject_id', 'teacher_id');
    }
}
