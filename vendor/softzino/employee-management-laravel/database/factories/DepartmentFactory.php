<?php

namespace Softzino\EmployeeManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Models\Employee;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        $head = Employee::query()->inRandomOrder()->first() ?? Employee::factory()->create();

        return [
            'name' => $this->faker->unique()->randomElement([
                'Human Resources',
                'Finance',
                'Engineering',
                'Sales',
                'Marketing',
                'Customer Support',
                'IT',
                'Legal',
                'Operations',
            ]),
            'is_active' => $this->faker->boolean,
            'head_id' => $head->id,
            'created_by' => 1,
            'created_by_name' => 'System',
            'updated_by' => null,
            'updated_by_name' => null,
        ];
    }

    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    public function withFakeHead(): static
    {
        return $this->state(function () {
            $head = Employee::factory()->create();

            return [
                'head_id' => $head->id,
            ];
        });
    }
}
