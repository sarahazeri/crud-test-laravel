<?php

namespace Database\Factories;

use App\Models\Enums\CustomerPrefixPhoneNumberEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
class CustomerFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date(),
            'prefix_phone_number' => fake()->randomElement(array_column(CustomerPrefixPhoneNumberEnum::cases(), 'value')),
            'phone_number' => fake()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'bank_account_number' => fake()->creditCardNumber(),
        ];
    }

    public function makeArrayFromEntity(array $info): array
    {
        $customer = new Customer();

        $customer->setId($info['id']);
        $entity['first_name'] = $customer->getFirstName();
        $entity['last_name'] = $customer->getLastName();
        $entity['date_of_birth'] = $customer->getDateOfBirth();
        $entity['prefix_phone_number'] = $customer->getPrefixPhoneNumber();
        $entity['phone_number'] = $customer->getPhoneNumber();
        $entity['email'] = $customer->getEmail();
        $entity['bank_account_number'] = $customer->getBankAccountNumber();

        return $entity;
    }


}
