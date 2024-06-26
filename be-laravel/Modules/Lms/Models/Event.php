<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Event.
 *
 * @package namespace Modules\Lms\Models;
 */
class Event extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "lms_events";
    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'subject_ids',
        'classroom_ids',
        'member_ids',
        'start_date',
        'end_date',
        'type',
        'status',
    ];

}
