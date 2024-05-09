<?php

namespace Database\Factories;

use App\Models\Enums\CustomerPrefixPhoneNumberEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'last_name' => fake()->name(),
            'date_of_birth' => fake()->date(),
            'prefix_phone_number' => fake()->randomElement(array_column(CustomerPrefixPhoneNumberEnum::cases(), 'value')),
            'phone_number' => fake()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'bank_account_number' => fake()->creditCardNumber(),
        ];
    }

}
