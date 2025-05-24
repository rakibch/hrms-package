<?php

namespace Softzino\EmployeeManagement;

use Illuminate\Support\ServiceProvider;
use Softzino\EmployeeManagement\Commands\SeedEmployeeManagement;
use Softzino\EmployeeManagement\Contracts\Repositories\CertificationRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeAddressRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeContactsRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeDocumentRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeEducationRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeProfessionalExperienceRepositoryInterface;
use Softzino\EmployeeManagement\Repositories\CertificationRepository;
use Softzino\EmployeeManagement\Repositories\EmployeeAddressRepository;
use Softzino\EmployeeManagement\Repositories\EmployeeContactRepository;
use Softzino\EmployeeManagement\Repositories\EmployeeDocumentRepository;
use Softzino\EmployeeManagement\Repositories\EmployeeEducationRepository;
use Softzino\EmployeeManagement\Repositories\EmployeeProfessionalExperienceRepository;
use Softzino\EmployeeManagement\Support\DatabaseConfig;

class EmployeeManagementServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedEmployeeManagement::class,
            ]);
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        config(['database.connections.employee_management' => DatabaseConfig::resolveConnection()]);

        // Merge package configuration
        $this->mergeConfigFrom(
            __DIR__ . '/../config/employee-management.php',
            'employee-management'
        );

        $this->app->bind(EmployeeAddressRepositoryInterface::class, EmployeeAddressRepository::class);
        $this->app->bind(EmployeeContactsRepositoryInterface::class, EmployeeContactRepository::class);
        $this->app->bind(EmployeeDocumentRepositoryInterface::class, EmployeeDocumentRepository::class);
        $this->app->bind(EmployeeEducationRepositoryInterface::class, EmployeeEducationRepository::class);
        $this->app->bind(CertificationRepositoryInterface::class, CertificationRepository::class);
        $this->app->bind(EmployeeProfessionalExperienceRepositoryInterface::class, EmployeeProfessionalExperienceRepository::class);
    }
}
