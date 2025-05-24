<?php

use Illuminate\Testing\Fluent\AssertableJson;

it('can fetch departments', function () {
    $response = $this->getJson('/departments/list');
    $response->assertStatus(200)
        ->assertJson(fn (AssertableJson $json) =>
        $json->has(3)
        );
});
