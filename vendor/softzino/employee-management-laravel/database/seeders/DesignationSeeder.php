<?php

namespace Softzino\EmployeeManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Softzino\EmployeeManagement\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Designation::factory()->count(5)->create();
    }
}
