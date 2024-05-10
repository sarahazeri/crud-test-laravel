<?php

namespace Tests\Feature;

use App\Models\Enums\CustomerPrefixPhoneNumberEnum;
use Tests\TestCase;
use App\Models\Entities\Customer;

class CustomerTestTDD extends TestCase
{
    public function testCreateCustomer()
    {
        $email = fake()->unique()->safeEmail();
        $response = $this->postJson('/api/customers', [
            'first_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date(),
            'prefix_phone_number' => fake()->randomElement(array_column(CustomerPrefixPhoneNumberEnum::cases(), 'value')),
            'phone_number' => fake()->numerify('##########'),
            'email' => $email,
            'bank_account_number' => fake()->creditCardNumber()
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('customers', ['email' => $email]);
    }

    public function testReadCustomer()
    {
        $email = fake()->unique()->safeEmail();
        $firstname = fake()->name();
        $customer = Customer::factory()->create([
            'first_name' => $firstname,
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date(),
            'prefix_phone_number' => fake()->randomElement(array_column(CustomerPrefixPhoneNumberEnum::cases(), 'value')),
            'phone_number' => fake()->numerify('##########'),
            'email' => $email,
            'bank_account_number' => fake()->creditCardNumber()
        ]);

        $response = $this->getJson('/api/customers/' . $customer->id);

        $response->assertStatus(200)
            ->assertJson([
                'firstName' => $firstname,
                'email' => $email
            ]);
    }

    public function testUpdateCustomer()
    {
        $customer = Customer::factory()->create();

        $response = $this->putJson('/api/customers/' . $customer->id, [
            'first_name' => 'UpdatedFirstName',
            'last_name' => $customer->last_name,
            'date_of_birth' => $customer->date_of_birth,
            'prefix_phone_number' => CustomerPrefixPhoneNumberEnum::getEnumByName($customer->prefix_phone_number),
            'phone_number' => $customer->phone_number,
            'email' => $customer->email,
            'bank_account_number' => $customer->bank_account_number
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', ['id' => $customer->id, 'first_name' => 'UpdatedFirstName']);
    }

    public function testDeleteCustomer()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson('/api/customers/' . $customer->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
