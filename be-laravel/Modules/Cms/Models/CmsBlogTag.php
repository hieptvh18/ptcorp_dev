<?php

namespace Modules\Cms\Models;

use Modules\Core\Traits\CoreHasAlias;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CmsBlogTag.
 *
 * @package namespace Modules\Cms\Models;
 */
class CmsBlogTag extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes;
    use CoreHasUserAudit, CoreHasAlias;

    protected $table = "lms_cms_blog_tags";
    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function blogs()
    {
        return $this->belongsToMany(CmsBlog::class, 'lms_cms_blog_tag_map', 'tag_id', 'blog_id');
    }
}
