<?php

namespace App\Models\Repositories\Customer\Command;

use App\Models\Entities\Customer;
use App\Models\Repositories\Customer\RedisCustomerRepository;
use Illuminate\Support\Collection;

class CustomerCommandRepository implements ICustomerCommandRepository
{
    private ICustomerCommandRepository $repository;
    private RedisCustomerRepository $redisRepository;

    public function __construct()
    {
        $this->repository = new MySqlCustomerCommandRepository();
        $this->redisRepository = new RedisCustomerRepository();
    }

    public function getOneById(int $id): null|Customer
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getOneById',
            'id' => $id,
        ]);

        $entity = $this->redisRepository->get($cacheKey);

        if ($entity === null) {
            $entity = $this->repository->getOneById($id);
            $this->redisRepository->put($cacheKey, $entity);
        }

        return $entity;
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

    public function delete(Customer $customer): int
    {
        $this->redisRepository->clear();

        return $this->repository->delete($customer);
    }
}
