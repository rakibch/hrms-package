<?php

namespace Softzino\EmployeeManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Softzino\EmployeeManagement\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::factory()
            ->count(5)
            ->create();
    }
}
