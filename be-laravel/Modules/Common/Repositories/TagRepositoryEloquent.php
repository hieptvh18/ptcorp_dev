<?php

namespace Modules\Common\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Common\Repositories\TagRepository;
use Modules\Common\Models\Tag;
use Modules\Common\Validators\TagValidator;

/**
 * Class TagRepositoryEloquent.
 *
 * @package namespace Modules\Common\Repositories;
 */
class TagRepositoryEloquent extends BaseRepository implements TagRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tag::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
