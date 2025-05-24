<?php

use Illuminate\Testing\Fluent\AssertableJson;
use Softzino\EmployeeManagement\Models\Designation;

it('can fetch designations', function () {
    $response = $this->getJson('/designations');
    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
        $json->has(8)
        );
});

it('fetches a single designation by id', function () {
    $designation = Designation::all()->pluck('id')[0];

    $response = $this->getJson("/designations/{$designation}");

    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
        $json->where('id', $designation)
            ->etc()
        );
});

it('toggles the designation status and returns success', function () {
    $designation = Designation::first();
    $response = $this->putJson("/designations/{$designation->id}/toggle-status");
    $response->assertStatus(200)
        ->assertJson([
            'success' => $response,
        ]);
});

