<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class EventLog.
 *
 * @package namespace Modules\Lms\Models;
 */
class EventLog extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "lms_event_logs";
    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'member_id',
        'status'
    ];

}
