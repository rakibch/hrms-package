<?php
namespace Softzino\EmployeeManagementApi\Providers;
use Illuminate\Support\ServiceProvider;
use Softzino\EmployeeManagementApi\Services\EmployeeService;
use Softzino\EmployeeManagementApi\Services\DepartmentService;
class EmploymentApiServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(dirname(__DIR__, 2) . '/configs/employee-management.php', 'employee-management');
        $this->loadRoutesFrom(dirname(__DIR__, 2) . '/routes/api.php');
        $this->loadRoutesFrom(dirname(__DIR__, 2) . '/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'employee-management');
    }
    public function register()
    {
        // Bind the EmployeeService to the container
        $this->app->singleton(EmployeeService::class, function ($app) {
            return new EmployeeService();
        });

        // Bind the DepartmentService to the container
        $this->app->singleton(DepartmentService::class, function ($app) {
            return new DepartmentService();
        });
    }
}
