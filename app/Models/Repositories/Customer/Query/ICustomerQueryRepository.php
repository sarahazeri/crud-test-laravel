<?php

namespace App\Models\Repositories\Customer\Query;

use App\Models\Entities\Customer;
use Illuminate\Support\Collection;

interface ICustomerQueryRepository
{
    public function getOneById(int $id): null|Customer;

    public function getAllByIds(array $ids): Collection;

    public function getOneByFirstName(string $firstName): null|Customer;

    public function getOneByLastName(string $lastName): null|Customer;

    public function getOneByDateOfBirth(string $dateOfBirth): null|Customer;

}
