<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Notification.
 *
 * @package namespace Modules\Lms\Models;
 */
class Notification extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = "lms_notifications";
    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'member_id',
        'notification_config_id'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
