<?php

namespace Modules\Common\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterProvince implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('province_id')) {
            $province_id = request()->query('province_id');
            $model = $model->where('province_id', $province_id);
        }

        return $model;
    }
}
