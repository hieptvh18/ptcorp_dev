<?php

namespace Modules\Notification\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Notification\Repositories\EmailTemplateRepository;
use Modules\Notification\Models\EmailTemplate;
use Modules\Notification\Validators\EmailTemplateValidator;

/**
 * Class EmailTemplateRepositoryEloquent.
 *
 * @package namespace Modules\Notification\Repositories;
 */
class EmailTemplateRepositoryEloquent extends BaseRepository implements EmailTemplateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EmailTemplate::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'subject_name'  => 'like',
                'alias' => 'like'
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
