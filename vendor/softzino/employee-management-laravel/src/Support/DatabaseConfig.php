<?php

namespace Softzino\EmployeeManagement\Support;

class DatabaseConfig
{
    public static function resolveConnection(): array
    {
        $projectDefault = config('database.default', 'pgsql');
        $defaultConnection = in_array($projectDefault, ['sqlite', 'testing', null]) ? 'pgsql' : $projectDefault;
        $default = config("database.connections.{$defaultConnection}", []);

        return array_merge($default, [
            'driver' => env('EMP_MGMT_DB_DRIVER', $default['driver'] ?? 'pgsql'),
            'url' => null,
            'host' => env('EMP_MGMT_DB_HOST', $default['host'] ?? 'pgsql'),
            'port' => env('EMP_MGMT_DB_PORT', $default['port'] ?? 5432),
            'database' => env('EMP_MGMT_DB_DATABASE', $default['database'] ?? 'st_hrms_project_test'),
            'username' => env('EMP_MGMT_DB_USERNAME', $default['username'] ?? 'sail'),
            'password' => env('EMP_MGMT_DB_PASSWORD', $default['password'] ?? 'password'),
            'charset' => env('EMP_MGMT_DB_CHARSET', $default['charset'] ?? 'utf8'),
            'prefix' => env('EMP_MGMT_DB_PREFIX', $default['prefix'] ?: 'emp_mgmt_'),
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ]);
    }
}
