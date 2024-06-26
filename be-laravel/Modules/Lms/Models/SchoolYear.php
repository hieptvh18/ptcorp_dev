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
 * Class SchoolYear.
 *
 * @package namespace Modules\Lms\Models;
 */
class SchoolYear extends Model implements Transformable
{
    use TransformableTrait, CoreHasAlias, CoreHasUserAudit, CoreHasUniqueCode, SoftDeletes;

    protected $table = 'lms_school_years';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'alias',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'lms_member_school_year_map', 'school_year_id', 'member_id');
    }
}
