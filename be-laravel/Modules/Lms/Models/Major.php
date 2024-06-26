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
 * Class Major.
 *
 * @package namespace Modules\Lms\Models;
 */
class Major extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes, CoreHasAlias, CoreHasUniqueCode;

    protected $table = "lms_majors";
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

    public function subjects()
    {
        return $this->belongsToMany(Major::class, 'lms_major_subject_map', 'major_id', 'subject_id');
    }

    public function school_levels()
    {
        return $this->belongsToMany(SchoolLevel::class, 'lms_major_school_level_map', 'major_id', 'school_level_id');
    }

}
