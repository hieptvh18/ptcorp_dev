<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasAlias;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Campain.
 *
 * @package namespace Modules\Notification\Models;
 */
class Campain extends Model implements Transformable
{
    use TransformableTrait, CoreHasAlias, CoreHasUserAudit, SoftDeletes;

    protected $table = "notification_campains";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'content',
        'status',
        'published_at'
    ];

}
