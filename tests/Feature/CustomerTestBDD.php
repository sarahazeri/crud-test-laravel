<?php

namespace Tests\Feature;

use App\Models\Enums\CustomerPrefixPhoneNumberEnum;
use Tests\TestCase;
use App\Models\Customer;

class CustomerTestBDD extends TestCase
{
    public function testReadCustomer()
    {
        $customer = Customer::factory()->create();

        $response = $this->getJson('/api/customers/' . $customer->id);

        $response->assertStatus(200)
            ->assertJson($customer->toResponse());
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

        $updatedCustomer = Customer::findOrFail($customer->id);
        $this->assertEquals('UpdatedFirstName', $updatedCustomer->first_name);
    }

    public function testDeleteCustomer()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson('/api/customers/' . $customer->id);
        $response->assertStatus(204);

        $this->assertDatabaseMissing($customer, ['id' => $customer->id]);
    }
}
