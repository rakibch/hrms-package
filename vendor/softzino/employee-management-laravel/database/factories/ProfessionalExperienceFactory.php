<?php

namespace Softzino\EmployeeManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagement\Models\ProfessionalExperience;

class ProfessionalExperienceFactory extends Factory
{
    protected $model = ProfessionalExperience::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-10 years', '-1 year');
        $isRunning = $this->faker->boolean();

        return [
            'employee_id' => Employee::factory(),
            'institution_name' => $this->faker->company,
            'designation' => $this->faker->jobTitle,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $isRunning ? null : $this->faker->dateTimeBetween($startDate, 'now')->format('Y-m-d'),
            'is_running' => $isRunning,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
