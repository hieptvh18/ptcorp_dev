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
 * Class Skill.
 *
 * @package namespace Modules\Lms\Models;
 */
class Skill extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes, CoreHasAlias, CoreHasUniqueCode;

    protected $table = "lms_skills";
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

    public function schoolLevels()
    {
        return $this->belongsToMany(SchoolLevel::class, 'lms_skill_school_level_map', 'skill_id', 'school_level_id');
    }

}
