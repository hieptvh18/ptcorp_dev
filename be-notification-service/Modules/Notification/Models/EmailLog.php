<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * Class EmailLog.
 *
 * @package namespace Modules\Notification\Models;
 */
class EmailLog extends Model implements Transformable
{
    use TransformableTrait, HasUuids;

    protected $table = "notification_email_logs";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'subject',
        'recipient',
        'sender',
        'cc',
        'bcc',
        'variables',
        'template_id',
        'template_forzen',
        'error',
        'bizapp_alias'
    ];

    // protected $casts = [
    //     'template_forzen' => [
    //         'name' => 'string',
    //         'render' => 'json',
    //         'hash' => 'string',
    //     ],
    // ];

    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id');
    }
}
