<?php

namespace App\Models\Factories;

use App\Models\Entities\Customer;
use App\Models\Enums\CustomerPrefixPhoneNumberEnum;
use Eghamat24\DatabaseRepository\Models\Entity\Entity;
use Eghamat24\DatabaseRepository\Models\Factories\Factory;
use Eghamat24\DatabaseRepository\Models\Factories\IFactory;
use Illuminate\Support\Collection;
use stdClass;

class CustomerFactory implements IFactory
{

    public function makeCollectionOfEntities(Collection|array $entities): Collection
    {
        $customers = collect();
        foreach ($entities as $entity) {
            $customers->push($this->makeEntityFromStdClass($entity));
        }
        return $customers;
    }

    public function makeEntityFromStdClass(stdClass $entity): Entity
    {
        $customer = new Customer();

        $customer->setId($entity->id);
        $customer->setFirstName($entity->first_name);
        $customer->setLastName($entity->last_name);
        $customer->setDateOfBirth($entity->date_of_birth);
        $customer->setPrefixPhoneNumber(CustomerPrefixPhoneNumberEnum::getEnumByName($entity->prefix_phone_number));
        $customer->setPhoneNumber($entity->phone_number);
        $customer->setFullPhoneNumber($entity->prefix_phone_number . $entity->phone_number);
        $customer->setEmail($entity->email);
        $customer->setBankAccountNumber($entity->bank_account_number);
        $customer->setCreatedAt($entity->created_at);
        $customer->setUpdatedAt($entity->updated_at);

        return $customer;
    }

    public function makeEntityFromArray(array $entity): Entity
    {
        return $this->changeEntityFromArray(new Customer(), $entity);
    }

    public function changeEntityFromArray(Customer $customer, array $entity): Entity
    {
        $customer->setFirstName($entity['first_name']);
        $customer->setLastName($entity['last_name']);
        $customer->setDateOfBirth($entity['date_of_birth']);
        $customer->setPrefixPhoneNumber(CustomerPrefixPhoneNumberEnum::getEnumByName($entity['prefix_phone_number']));
        $customer->setPhoneNumber($entity['phone_number']);
        $customer->setFullPhoneNumber($entity['prefix_phone_number'] . $entity['phone_number']);
        $customer->setEmail($entity['email']);
        $customer->setBankAccountNumber($entity['bank_account_number']);

        return $customer;
    }

}
