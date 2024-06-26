<?php

namespace Modules\Cms\Repositories;

use Modules\Cms\Repositories\Criteria\FilterCmsReview;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsReviewRepository;
use Modules\Cms\Validators\CmsReviewValidator;
use Codebyray\ReviewRateable\Models\Rating;
use Modules\Cms\Models\CourseReview;

/**
 * Class CmsReviewRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsReviewRepositoryEloquent extends BaseRepository implements CmsReviewRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseReview::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'title' => 'like',
                'body' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsReview::class));

    }

}
