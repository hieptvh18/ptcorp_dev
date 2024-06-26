<?php

namespace Modules\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Course.
 *
 * @package namespace Modules\Cms\Models;
 */
class CourseReview extends \Codebyray\ReviewRateable\Models\Rating
{

    protected $connection = 'workspace_db';

    public function reviewrateable()
    {
        return $this->morphTo(__FUNCTION__, 'reviewrateable_type', 'reviewrateable_id');
    }

    public function course(){
        return $this->belongsTo(\Modules\Cms\Models\Course::class,'reviewrateable_id');
    }

    public function authorReview()
    {
        return $this->belongsTo(\App\Models\User::class,'author_id');
    }
}
