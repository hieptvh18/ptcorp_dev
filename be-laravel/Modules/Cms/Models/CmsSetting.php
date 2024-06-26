<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasAlias;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CmsSetting.
 *
 * @package namespace Modules\Cms\Models;
 */
class CmsSetting extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes;

    protected $table = 'lms_cms_settings';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'website_id',
        'group',
        'setting'
    ];

    protected $casts = [
        'setting' => 'json',
    ];
}
