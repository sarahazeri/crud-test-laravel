<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Customer;

class CustomerTestDDD extends TestCase
{
    public function testReadCustomer()
    {
        $customer = Customer::factory()->create();

        $retrievedCustomer = Customer::findOrFail($customer->id);

        $this->assertEquals($customer->toArray(), $retrievedCustomer->toArray());
    }

    public function testUpdateCustomer()
    {
        $customer = Customer::factory()->create();

        $customer->first_name = 'UpdatedFirstName';
        $customer->save();

        $updatedCustomer = Customer::findOrFail($customer->id);

        $this->assertEquals('UpdatedFirstName', $updatedCustomer->first_name);
    }

    public function testDeleteCustomer()
    {
        $customer = Customer::factory()->create();

        $customer->delete();

        $this->assertDatabaseMissing($customer, ['id' => $customer->id]);
    }
}
