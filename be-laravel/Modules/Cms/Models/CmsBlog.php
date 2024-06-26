<?php

namespace Modules\Cms\Models;

use Modules\Core\Traits\CoreHasAlias;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\CoreHasUserAudit;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasLogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CmsBlog.
 *
 * @package namespace Modules\Cms\Models;
 */
class CmsBlog extends Model implements Transformable
{
    use TransformableTrait, SoftDeletes, CoreHasUniqueCode;
    use CoreHasUserAudit, CoreHasLogsActivity;

    protected $table = "lms_cms_blogs";
    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'alias',
        'short_description',
        'description',
        'image_thumbnail',
        'image_cover',
        'type',
        'published_at',
        'finished_at',
        'status',
        'show_type',
        'action_click_type',
        'is_featured',
        'bizapp',
        'meta_title',
        'meta_description',
        'meta_url',
        'meta_keyword'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected $hidden = ['pivot'];

    public function categories()
    {
        return $this->belongsToMany(CmsCategory::class, 'lms_cms_blog_category_map', 'blog_id', 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(CmsBlogTag::class, 'lms_cms_blog_tag_map', 'blog_id', 'tag_id');
    }
}
