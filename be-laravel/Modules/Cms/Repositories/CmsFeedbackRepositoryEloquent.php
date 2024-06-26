<?php

namespace Modules\Cms\Repositories;

use Modules\Cms\Repositories\Criteria\FilterCmsFeedback;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsFeedbackRepository;
use Modules\Cms\Models\CmsFeedback;
use Modules\Cms\Validators\CmsFeedbackValidator;

/**
 * Class CmsFeedbackRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsFeedbackRepositoryEloquent extends BaseRepository implements CmsFeedbackRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CmsFeedback::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'description'=>'like',
                'student_name'=>'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsFeedback::class));
    }

}
