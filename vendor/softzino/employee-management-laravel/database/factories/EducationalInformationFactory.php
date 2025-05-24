<?php

namespace Softzino\EmployeeManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Softzino\EmployeeManagement\Models\EducationalInformation;
use Softzino\EmployeeManagement\Models\Employee;

class EducationalInformationFactory extends Factory
{
    protected $model = EducationalInformation::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-10 years', '-4 years');
        $endDate = $this->faker->optional()->dateTimeBetween($startDate, 'now');

        return [
            'employee_id' => Employee::factory(),
            'institution_name' => $this->faker->company . ' University',
            'degree' => $this->faker->randomElement(['BSc', 'MSc', 'PhD', 'Diploma']),
            'field_of_study' => $this->faker->randomElement(['Computer Science', 'Business', 'Engineering']),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate ? $endDate->format('Y-m-d') : null,
            'grade' => $this->faker->randomFloat(2, 2.0, 4.0),
            'certificate_file_path' => 'certificates/' . $this->faker->uuid . '.pdf',
            'is_running' => $endDate === null,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
