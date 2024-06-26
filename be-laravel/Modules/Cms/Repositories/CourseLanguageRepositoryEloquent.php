<?php

namespace Modules\Cms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CourseLanguageRepository;
use Modules\Cms\Models\CourseLanguage;
use Modules\Cms\Validators\CourseLanguageValidator;

/**
 * Class CourseLanguageRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CourseLanguageRepositoryEloquent extends BaseRepository implements CourseLanguageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CourseLanguage::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'code' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterIsActive::class));
    }

}
