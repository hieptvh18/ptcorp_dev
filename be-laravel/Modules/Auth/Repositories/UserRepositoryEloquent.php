<?php

namespace Modules\Auth\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Modules\Core\Repositories\Criteria\MyCriteria;
use Modules\Core\Repositories\Criteria\SortCriteria;
use Modules\Core\Repositories\Criteria\FilterIsActive;
use Modules\Core\Repositories\Criteria\FilterCreatedAtCriteria;
use Modules\Core\Repositories\Criteria\FilterStatus;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace Modules\Auth\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    protected $fieldSearchable = [
        'id' => 'like',
        'username' => 'like',
        'email' => 'like',

    ];


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        // $this->pushCriteria(app(MyCriteria::class));
        $this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(app(FilterStatus::class));
        $this->pushCriteria(app(FilterCreatedAtCriteria::class));
        $this->pushCriteria(app(SortCriteria::class));
    }

    public function getStatisUserByMonth($month, $year)
    {
        $this->skipCriteria(true);
        $user_by_month = $this->select(DB::raw("(DATE_FORMAT(created_at, '%d')) as day"), DB::raw("count('id') as total_user"))
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%d')"))
            ->get();
        return $user_by_month;
    }
}
