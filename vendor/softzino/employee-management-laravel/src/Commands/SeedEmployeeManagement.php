<?php

namespace Softzino\EmployeeManagement\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedEmployeeManagement extends Command
{
    protected $signature = 'employee-management-laravel:seed
                            {--seed-departments : Seed departments}
                            {--seed-designations : Seed designations}
                            {--all : Seed all default data}';

    protected $description = 'Seed default data for Employee Management';

    public function handle(): void
    {
        // Determine which seeders to run
        $seedDepartments = $this->option('seed-departments') || $this->option('all');
        $seedDesignations = $this->option('seed-designations') || $this->option('all');

        if ($seedDepartments) {
            Artisan::call('db:seed', [
                '--class' => 'Softzino\EmployeeManagement\Database\Seeders\DepartmentSeeder',
            ]);
            $this->info('✅ Departments have been seeded.');
        }

        if ($seedDesignations) {
            Artisan::call('db:seed', [
                '--class' => 'Softzino\EmployeeManagement\Database\Seeders\DesignationSeeder',
            ]);
            $this->info('✅ Designations have been seeded.');
        }

        if (! $seedDepartments && ! $seedDesignations) {
            $this->warn('⚠️ No seeding option provided. Use --seed-departments, --seed-designations, or --all');
        }
    }
}
