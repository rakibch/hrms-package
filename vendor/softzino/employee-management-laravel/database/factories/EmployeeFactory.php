<?php

namespace Softzino\EmployeeManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Softzino\EmployeeManagement\Models\Employee;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull(),
            'identity_type' => $this->faker->randomElement(['automatic', 'manual']),
            'employee_no' => $this->faker->unique()->numerify('########'),
            'join_date' => $this->faker->date(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'profile_image' => $this->faker->imageUrl(),
            'dob' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'marital_status' => $this->faker->randomElement(['single', 'married']),
            'religion' => $this->faker->randomElement(['Christianity', 'Islam', 'Hinduism']),
            'blood_group' => $this->faker->randomElement(['A+', 'O-', 'B+', 'AB-']),
            'personal_contact_no' => $this->faker->phoneNumber(),
            'personal_email' => $this->faker->unique()->safeEmail(),
            'permanent_address_same_as_present_address' => $this->faker->boolean(),
            'work_address_same_as_present_address' => $this->faker->boolean(),
            'job_type' => $this->faker->randomElement(['full-time', 'part-time', 'contract']),
            'employment_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract']),
            'official_contact_no' => $this->faker->phoneNumber(),
            'official_email' => $this->faker->unique()->safeEmail(),
            'profile_completion_status' => $this->faker->randomElement(['draft', 'complete']),
            'employment_status' => $this->faker->randomElement(['active', 'inactive', 'terminated']),
            'created_by' => $this->faker->randomDigitNotNull(),
            'created_by_name' => $this->faker->name(),
            'updated_by' => $this->faker->randomDigitNotNull(),
            'updated_by_name' => $this->faker->name(),
        ];
    }
}
