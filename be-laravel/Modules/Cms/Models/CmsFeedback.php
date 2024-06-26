<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CmsFeedback.
 *
 * @package namespace Modules\Cms\Models;
 */
class CmsFeedback extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes;

    protected $table = 'lms_cms_feedbacks';

    protected $connection = 'workspace_db';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'student_name',
        'student_avatar_url',
        'type',
        'is_show_homepage',
        'sort_order',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean','is_show_homepage'=>'boolean'];
}
