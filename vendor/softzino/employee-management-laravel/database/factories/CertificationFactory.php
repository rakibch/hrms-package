<?php

namespace Softzino\EmployeeManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Softzino\EmployeeManagement\Models\Certification;
use Softzino\EmployeeManagement\Models\Employee;

class CertificationFactory extends Factory
{
    protected $model = Certification::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'course_name' => $this->faker->sentence(3),
            'issuing_organization' => $this->faker->company,
            'start_date' => $this->faker->dateTimeBetween('-2 years', '-1 year')->format('Y-m-d'),
            'completion_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'certificate_urls' => [$this->faker->url],
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
