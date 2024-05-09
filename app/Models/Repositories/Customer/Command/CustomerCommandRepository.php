<?php

namespace App\Models\Repositories\Customer\Query;

use App\Models\Customer;
use App\Models\Repositories\Customer\RedisCustomerRepository;
use Illuminate\Support\Collection;

class CustomerCommandRepository implements ICustomerCommandRepository
{
    private ICustomerQueryRepository $repository;
    private RedisCustomerRepository $redisRepository;

    public function __construct()
    {
        $this->repository = new MySqlCustomerCommandRepository();
        $this->redisRepository = new RedisCustomerRepository();
    }

    public function create(Customer $customer): Customer
    {
        $this->redisRepository->clear();

        return $this->repository->create($customer);
    }

    public function update(Customer $customer): int
    {
        $this->redisRepository->clear();

        return $this->repository->update($customer);
    }
}
