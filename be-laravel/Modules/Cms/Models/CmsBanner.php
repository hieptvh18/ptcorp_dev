<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CmsBanner.
 *
 * @package namespace Modules\Cms\Models;
 */
class CmsBanner extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes;

    protected $table =  'lms_cms_banners';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'image_url',
        'video_url',
        'postition',
        'start_date',
        'end_date',
        'link_redirect',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];
}
