<?php

namespace App\Core\Traits;

use App\Core\QueryBuilderWithCache;
use App\Core\Traits;

trait QueryBuilderCacheableTrait
{
    protected function newBaseQueryBuilder()
    {
        $connection = $this->getConnection();

        return new QueryBuilderWithCache(
            $connection,
            $connection->getQueryGrammar(),
            $connection->getPostProcessor(),
            $this->cacheTime()
        );
    }

    protected function cacheTime()
    {
        return property_exists($this, 'cacheTime') ? $this->cacheTime : 0;
    }
}
