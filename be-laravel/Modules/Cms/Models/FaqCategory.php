<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FaqCategory.
 *
 * @package namespace Modules\Cms\Models;
 */
class FaqCategory extends Model implements Transformable
{
    use TransformableTrait,CoreHasUserAudit, SoftDeletes;

    protected $table =  'lms_cms_faq_categories';

    protected $connection = 'workspace_db';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'image_url',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];
}
