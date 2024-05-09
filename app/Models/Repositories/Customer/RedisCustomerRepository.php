<?php

namespace App\Models\Repositories\Customer;

use Eghamat24\DatabaseRepository\Models\Repositories\RedisRepository;
use Eghamat24\DatabaseRepository\Models\Repositories\CacheStrategies\QueryCacheStrategy;

class RedisCustomerRepository extends RedisRepository
{
    use QueryCacheStrategy;

    public function __construct()
    {
        $this->cacheTag = 'customers';
        parent::__construct();
    }
}
