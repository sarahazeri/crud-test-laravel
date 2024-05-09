<?php

namespace App\Models\Repositories\Customer\Query;

use App\Models\Customer;
use Illuminate\Support\Collection;

interface ICustomerCommandRepository
{
    public function create(Customer $customer): Customer;

    public function update(Customer $customer): int;

}
