<?php

namespace Modules\Cms\Repositories;

use Modules\Cms\Repositories\Criteria\FilterCmsFaq;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsFaqRepository;
use Modules\Cms\Models\Faq;
use Modules\Cms\Validators\FaqValidator;

/**
 * Class FaqRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsFaqRepositoryEloquent extends BaseRepository implements CmsFaqRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Faq::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'question' => 'like',
                'answer' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsFaq::class));
    }

}
