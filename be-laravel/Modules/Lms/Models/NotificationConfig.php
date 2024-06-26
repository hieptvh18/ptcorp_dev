<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class NotificationConfig.
 *
 * @package namespace Modules\Lms\Models;
 */
class NotificationConfig extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes;

    protected $table = "lms_notification_configs";

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'file_attach_url',
        'link_attach_url',
        'published_at',
        'type',
        'is_active',
    ];

    protected $casts = ['is_active'=>'boolean'];

    public function modeOptions(): HasMany
    {
        return $this->hasMany(NotificationConfigMode::class,'notification_config_id');
    }

    public function classRooms(){
        return $this->morphedByMany(ClassRoom::class, 'notififcationable');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class,'notification_config_id');
    }
}


























