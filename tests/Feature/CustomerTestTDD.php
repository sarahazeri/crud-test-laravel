<?php


use Tests\TestCase;
use App\Models\Customer;

class CustomerTestTDD extends TestCase
{
    public function testCreateCustomer()
    {
        $response = $this->postJson('/api/customers', [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'prefix_phone_number' => '+1',
            'phone_number' => '234567890',
            'email' => 'john@example.com',
            'bank_account_number' => '1234567890'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('customers', ['email' => 'john@example.com']);
    }

    public function testReadCustomer()
    {
        $customer = Customer::factory()->create([
            'firstname' => 'Jane',
            'lastname' => 'Doe',
            'date_of_birth' => '1995-05-05',
            'prefix_phone_number' => '+98',
            'phone_number' => '76543210',
            'email' => 'jane@example.com',
            'bank_account_number' => '0987654321'
        ]);

        $response = $this->getJson('/api/customers/' . $customer->getId());

        $response->assertStatus(200)
            ->assertJson([
                'firstname' => 'Jane',
                'email' => 'jane@example.com'
            ]);
    }

    public function testUpdateCustomer()
    {
        $customer = Customer::factory()->create();

        $response = $this->putJson('/api/customers/' . $customer->getId(), [
            'firstname' => 'UpdatedFirstName',
// Update other fields as needed
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', ['id' => $customer->getId(), 'firstname' => 'UpdatedFirstName']);
    }

    public function testDeleteCustomer()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson('/api/customers/' . $customer->getId());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('customers', ['id' => $customer->getId()]);
    }
}
