<?php

namespace App\Models\Repositories\Customer\Command;

use App\Models\Entities\Customer;
use Illuminate\Support\Collection;

interface ICustomerCommandRepository
{
    public function getOneById(int $id): null|Customer;

    public function create(Customer $customer): Customer;

    public function update(Customer $customer): int;

    public function delete(Customer $customer): int;

}
