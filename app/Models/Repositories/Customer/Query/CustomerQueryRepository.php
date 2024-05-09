<?php

namespace App\Models\Repositories\Customer\Query;

use App\Models\Entities\Customer;
use App\Models\Repositories\Customer\RedisCustomerRepository;
use Illuminate\Support\Collection;

class CustomerQueryRepository implements ICustomerQueryRepository
{
    private ICustomerQueryRepository $repository;
    private RedisCustomerRepository $redisRepository;

    public function __construct()
    {

        $this->repository = new MySqlCustomerQueryRepository();
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

    public function getAllByIds(array $ids): Collection
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getAllByIds',
            'id' => $ids,
        ]);

        $entities = $this->redisRepository->get($cacheKey);

        if ($entities === null) {
            $entities = $this->repository->getAllByIds($ids);
            $this->redisRepository->put($cacheKey, $entities);
        }

        return $entities;
    }

    public function getOneByFirstName(string $firstName): null|Customer
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getOneByFirstName',
            'firstName' => $firstName,
        ]);

        $entity = $this->redisRepository->get($cacheKey);

        if ($entity === null) {
            $entity = $this->repository->getOneByFirstName($firstName);
            $this->redisRepository->put($cacheKey, $entity);
        }

        return $entity;
    }

    public function getOneByLastName(string $lastName): null|Customer
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getOneByLastName',
            'lastName' => $lastName,
        ]);

        $entity = $this->redisRepository->get($cacheKey);

        if ($entity === null) {
            $entity = $this->repository->getOneByLastName($lastName);
            $this->redisRepository->put($cacheKey, $entity);
        }

        return $entity;
    }

    public function getOneByDateOfBirth(string $dateOfBirth): null|Customer
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getOneByDateOfBirth',
            'dateOfBirth' => $dateOfBirth,
        ]);

        $entity = $this->redisRepository->get($cacheKey);

        if ($entity === null) {
            $entity = $this->repository->getOneByDateOfBirth($dateOfBirth);
            $this->redisRepository->put($cacheKey, $entity);
        }

        return $entity;
    }

    public function getAll(): Collection
    {
        $cacheKey = $this->redisRepository->makeKey([
            'function_name' => 'getAll',
        ]);

        $entities = $this->redisRepository->get($cacheKey);

        if ($entities === null) {
            $entities = $this->repository->getAll();
            $this->redisRepository->put($cacheKey, $entities);
        }

        return $entities;
    }
}
