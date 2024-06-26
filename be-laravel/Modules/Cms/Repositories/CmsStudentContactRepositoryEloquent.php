<?php

namespace Modules\Cms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Cms\Repositories\CmsStudentContactRepository;
use Modules\Cms\Models\CmsStudentContact;
use Modules\Cms\Validators\CmsStudentContactValidator;
use Modules\Cms\Repositories\Criteria\FilterCmsStudentContact;

/**
 * Class CmsStudentContactRepositoryEloquent.
 *
 * @package namespace Modules\Cms\Repositories;
 */
class CmsStudentContactRepositoryEloquent extends BaseRepository implements CmsStudentContactRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CmsStudentContact::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'mobile' => 'like',
                'message' => 'like',
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterCmsStudentContact::class));
    }

}
