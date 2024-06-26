<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CmsStudentContact.
 *
 * @package namespace Modules\Cms\Models;
 */
class CmsStudentContact extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;

    protected $table = 'lms_cms_student_contacts';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mobile',
        'message',
        'ip_address',
        'user_agent',
        'type'
    ];

    protected $casts = ['is_active' => 'boolean'];
}
