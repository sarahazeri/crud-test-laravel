<?php

namespace App\Models\Repositories\Customer\Query;

use App\Models\Customer;
use Database\Factories\CustomerFactory;
use Eghamat24\DatabaseRepository\Models\Repositories\MySqlRepository;
use Illuminate\Support\Collection;

class MySqlCustomerQueryRepository extends MySqlRepository implements ICustomerQueryRepository
{
    public function __construct()
    {
        $this->table = 'customers_view';
        $this->primaryKey = 'id';
        $this->softDelete = false;
        $this->factory = new CustomerFactory();

        parent::__construct();
    }

    public function getOneById(int $id): null|Customer
    {
        $customer = $this->newQuery()
            ->where('id', $id)
            ->first();

        return $customer ? $this->factory->makeEntityFromStdClass($customer) : null;
    }

    public function getAllByIds(array $ids): Collection
    {
        $customer = $this->newQuery()
            ->whereIn('id', $ids)
            ->get();

        return $this->factory->makeCollectionOfEntities($customer);
    }

    public function getOneByFirstName(string $firstName): null|Customer
    {
        $customer = $this->newQuery()
            ->where('first_name', $firstName)
            ->first();

        return $customer ? $this->factory->makeEntityFromStdClass($customer) : null;
    }

    public function getOneByLastName(string $lastName): null|Customer
    {
        $customer = $this->newQuery()
            ->where('last_name', $lastName)
            ->first();

        return $customer ? $this->factory->makeEntityFromStdClass($customer) : null;
    }

    public function getOneByDateOfBirth(string $dateOfBirth): null|Customer
    {
        $customer = $this->newQuery()
            ->where('date_of_birth', $dateOfBirth)
            ->first();

        return $customer ? $this->factory->makeEntityFromStdClass($customer) : null;
    }

    public function getAll(): Collection
    {
        $customer = $this->newQuery()
            ->get();

        return $this->factory->makeCollectionOfEntities($customer);
    }
}
