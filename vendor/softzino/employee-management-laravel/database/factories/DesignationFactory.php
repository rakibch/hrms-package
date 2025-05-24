<?php

namespace Softzino\EmployeeManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Softzino\EmployeeManagement\Models\Designation;

class DesignationFactory extends Factory
{
    protected $model = Designation::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->jobTitle(),
            'is_active' => $this->faker->boolean(80),
            'reporting_to_designation_id' => null,
            'created_by' => 1,
            'created_by_name' => 'System',
            'updated_by' => null,
            'updated_by_name' => null,
        ];
    }

    public function withReporter(Designation $reporter): static
    {
        return $this->state(fn () => [
            'reporting_to_designation_id' => $reporter->id,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'is_active' => true,
        ]);
    }
}
