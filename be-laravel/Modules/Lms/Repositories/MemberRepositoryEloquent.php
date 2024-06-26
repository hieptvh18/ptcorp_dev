<?php

namespace Modules\Lms\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Lms\Repositories\MemberRepository;
use Modules\Lms\Models\Member;
use Modules\Lms\Repositories\Criteria\FilterMember;
use Modules\Lms\Repositories\Criteria\FilterTypeMember;
use Modules\Lms\Validators\MemberValidator;

/**
 * Class MemberRepositoryEloquent.
 *
 * @package namespace Modules\Lms\Repositories;
 */
class MemberRepositoryEloquent extends BaseRepository implements MemberRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Member::class;
    }

    public function getFieldsSearchable()
    {
        return
            [
                'firstname' => 'like',
                'lastname' => 'like',
                'email' => 'like',
                'mobile' => 'like'
            ];
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterTypeMember::class));
        $this->pushCriteria(app(FilterMember::class));
    }

}
