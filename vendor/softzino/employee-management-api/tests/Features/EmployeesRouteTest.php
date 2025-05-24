<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Softzino\EmployeeManagement\Models\Employee;

it('can fetch employees', function () {
    $response = $this->getJson('/employees');
    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
        $json->has(1)
        );
});

it('fetches a single employee by id', function () {
    // Create an employee
    $employee = Employee::all()->pluck('id')[0];

    // Send a GET request to /employees/{id}
    $response = $this->getJson("/employees/{$employee}");

    // Assert response contains employee data
    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
        $json->where('id', $employee)
            ->etc()
        );
});

it('updates an employee status', function () {
    $employee = Employee::all()->pluck('id')[0];

    // Send a PUT request to update the status
    $payload = ['status' => 'inactive'];
    $response = $this->putJson("/employees/{$employee}/status", $payload);

    // Assert that the status is updated in response, and status code is 200
    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
        $json->where('id', $employee)
            ->where('employment_status', 'inactive')
            ->etc()
        );

    $this->assertDatabaseHas(Employee::class, [
        'id' => $employee,
        'employment_status' => 'inactive'
    ]);
});

