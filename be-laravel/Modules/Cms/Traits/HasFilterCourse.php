<?php

namespace Modules\Cms\Traits;

use Wildside\Userstamps\Userstamps;

trait HasFilterCourse
{

    use Userstamps;

    public function scopeCourseCountMasterData($query, $type, $ids = [])
    {
        if ($type == 'category') {
            return $query->withCount(['courses' => function ($que) use ($ids) {
                $que->whereHas('categories', function ($q) use ($ids) {
                    $q->whereIn('category_id', $ids);
                });
            }]);
        }
        if ($type == 'instructor') {
            return $query->withCount(['courses' => function ($que) use ($ids) {
                $que->whereHas('instructors', function ($q) use ($ids) {
                    $q->whereIn('instructor_id', $ids);
                });
            }]);
        }
        if ($type == 'level') {
            return $query->withCount(['courses' => function ($que) use ($ids) {
                $que->whereHas('levels', function ($q) use ($ids) {
                    $q->whereIn('course_level_id', $ids);
                });
            }]);
        }
        if ($type == 'language') {
            return $query->withCount(['courses' => function ($que) use ($ids) {
                $que->whereHas('languages', function ($q) use ($ids) {
                    $q->whereIn('language_id', $ids);
                });
            }]);
        }
    }
}
