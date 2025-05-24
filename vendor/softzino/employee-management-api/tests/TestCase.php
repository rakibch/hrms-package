<?php

namespace Softzino\EmploymentManagementApi\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Softzino\EmployeeManagement\EmployeeManagementServiceProvider;
use Softzino\EmployeeManagementApi\Providers\EmploymentApiServiceProvider;
use Softzino\EmploymentManagementApi\Tests\TestModels\User;

class TestCase extends Orchestra
{
    protected User $testUser;

    protected static $migrations;

    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Softzino\\EmploymentManagementApi\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            EmploymentApiServiceProvider::class,
            EmployeeManagementServiceProvider::class
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'pgsql');
        $app['config']->set('database.connections.pgsql', [
            'driver' => 'pgsql',
            'url' => null,
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);

        $app['config']->set('cache.default', 'array');
    }

    protected function setUpDatabase($app): void
    {
        $schema = $app['db']->connection()->getSchemaBuilder();

        $schema->create('users', function ($table) {
            $table->increments('id');
            $table->string('email');
        });

        foreach (self::$migrations as $migration) {
            $migration->up();
        }

        $this->testUser = User::create(['email' => 'test@user.com']);

    }
}
