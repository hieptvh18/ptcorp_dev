<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class NotificationConfig.
 *
 * @package namespace Modules\Lms\Models;
 */
class NotificationConfigMode extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "lms_notification_config_mode";

    protected $connection = 'workspace_db';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_config_id',
        'notitifcation_typeable',
        'notification_typeable_id'
    ];

    public function notififcationable()
    {
        return $this->morphTo(NotificationConfigMode::class,'notificationable');
    }

}
