<?php

namespace Softzino\EmployeeManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagement\Models\EmployeeContact;

class EmployeeContactFactory extends Factory
{
    protected $model = EmployeeContact::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'name' => $this->faker->name,
            'relationship' => $this->faker->randomElement(['Father', 'Mother', 'Brother', 'Sister', 'Spouse']),
            'contact_no' => $this->faker->phoneNumber,
            'street' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'created_by' => 1,
            'updated_by' => null,
        ];
    }
}
