<?php

namespace Modules\Lms\Repositories;

use Modules\Core\Repositories\Criteria\FilterIsActive;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\SkillRepository;
use Modules\Lms\Models\Skill;
use Modules\Lms\Validators\SkillValidator;

/**
 * Class SkillRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class SkillRepositoryEloquent extends BaseRepository implements SkillRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Skill::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'name' => 'like',
                'code' => 'like',
                'alias' => 'like',
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
