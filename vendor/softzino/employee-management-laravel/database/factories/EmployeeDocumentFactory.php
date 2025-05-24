<?php

namespace Softzino\EmployeeManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagement\Models\EmployeeDocument;

class EmployeeDocumentFactory extends Factory
{
    protected $model = EmployeeDocument::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'document_type' => $this->faker->randomElement(['Passport', 'ID Card', 'Visa', 'Certificate']),
            'document_path' => 'documents/' . $this->faker->uuid . '.pdf',
            'expiry_date' => ($date = $this->faker->optional()->dateTimeBetween('now', '+5 years')) ? $date->format('Y-m-d') : null,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
