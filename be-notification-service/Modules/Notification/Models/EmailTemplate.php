<?php

namespace Modules\Notification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasAlias;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class EmailTemplate.
 *
 * @package namespace Modules\Notification\Models;
 */
class EmailTemplate extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes, CoreHasAlias;

    protected $table = "notification_email_templates";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'subject_name',
        'alias',
        'content',
        'bizapp_alias'
    ];

     /**
     * Get the template hash.
     */
    public function getHash(): string
    {
        return md5($this->content . $this->layout?->content);
    }

}
