<?php

namespace Modules\Common\Repositories\Criteria;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterCountry implements CriteriaInterface
{

    public function apply($model, RepositoryInterface $repository)
    {
        if (request()->has('country_id')) {
            $country_id = request()->query('country_id');
            $model = $model->where('country_id', $country_id);
        }

        return $model;
    }
}
