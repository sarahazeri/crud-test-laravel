<?php

namespace App\Models\Resources;

use Eghamat24\DatabaseRepository\Models\Resources\Resource;

class CustomerResource extends Resource
{
    public function toArrayWithForeignKeys($customer): array
    {
        return $this->toArray($customer) + [

            ];
    }

    public function toArray($customer): array
    {
        return [
            'id' => $customer->getId(),
            'first_name' => $customer->getFirstName(),
            'last_name' => $customer->getLastName(),
            'date_of_birth' => $customer->getDateOfBirth(),
            'prefix_phone_number' => $customer->getPrefixPhoneNumber(),
            'phone_number' => $customer->getPhoneNumber(),
            'email' => $customer->getEmail(),
            'bank_account_number' => $customer->getBankAccountNumber(),
            'created_at' => $customer->getCreatedAt(),
            'updated_at' => $customer->getUpdatedAt(),

        ];
    }
}
