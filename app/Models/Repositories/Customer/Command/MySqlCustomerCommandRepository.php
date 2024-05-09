<?php

namespace App\Models\Repositories\Customer\Query;

use App\Models\Customer;
use Database\Factories\CustomerFactory;
use Eghamat24\DatabaseRepository\Models\Repositories\MySqlRepository;
use Illuminate\Support\Collection;

class MySqlCustomerCommandRepository extends MySqlRepository implements ICustomerCommandRepository
{
    public function __construct()
    {
        $this->table = 'customers';
        $this->primaryKey = 'id';
        $this->softDelete = false;
        $this->factory = new CustomerFactory();

        parent::__construct();
    }

    public function create(Customer $customer): Customer
    {
        $customer->setCreatedAt(date('Y-m-d H:i:s'));
        $customer->setUpdatedAt(date('Y-m-d H:i:s'));

        $id = $this->newQuery()
            ->insertGetId([
                'first_name' => $customer->getFirstName(),
                'last_name' => $customer->getLastName(),
                'date_of_birth' => $customer->getDateOfBirth(),
                'prefix_phone_number' => $customer->getPrefixPhoneNumber(),
                'phone_number' => $customer->getPhoneNumber(),
                'email' => $customer->getEmail(),
                'bank_account_number' => $customer->getBankAccountNumber(),
                'created_at' => $customer->getCreatedAt(),
                'updated_at' => $customer->getUpdatedAt(),
            ]);

        $customer->setId($id);

        return $customer;
    }

    public function update(Customer $customer): int
    {
        $customer->setUpdatedAt(date('Y-m-d H:i:s'));

        return $this->newQuery()
            ->where($this->primaryKey, $customer->getPrimaryKey())
            ->update([
                'first_name' => $customer->getFirstName(),
                'last_name' => $customer->getLastName(),
                'date_of_birth' => $customer->getDateOfBirth(),
                'prefix_phone_number' => $customer->getPrefixPhoneNumber(),
                'phone_number' => $customer->getPhoneNumber(),
                'email' => $customer->getEmail(),
                'bank_account_number' => $customer->getBankAccountNumber(),
                'updated_at' => $customer->getUpdatedAt(),
            ]);
    }
}
