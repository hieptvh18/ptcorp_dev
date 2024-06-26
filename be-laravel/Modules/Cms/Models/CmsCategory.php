<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cms\Traits\HasFilterCourse;
use Modules\Core\Traits\CoreHasAlias;
use Modules\Core\Traits\CoreHasUniqueCode;
use Modules\Core\Traits\CoreHasUserAudit;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CmsCategory.
 *
 * @package namespace Modules\Cms\Models;
 */
class CmsCategory extends Model implements Transformable
{
    use TransformableTrait, CoreHasUserAudit, SoftDeletes, CoreHasAlias, CoreHasUniqueCode, HasFilterCourse;

    protected $table = 'lms_cms_categories';

    protected $connection = 'workspace_db';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'code',
        'description',
        'type',
        'thumbnail_url',
        'is_active'
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function blogs()
    {
        return $this->belongsToMany(CmsBlog::class, 'lms_cms_blog_category_map', 'category_id', 'blog_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'lms_course_category_map', 'category_id', 'course_id');
    }
}
