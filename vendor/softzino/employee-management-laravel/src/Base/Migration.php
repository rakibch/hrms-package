<?php

namespace Softzino\EmployeeManagement\Base;

use Illuminate\Database\Migrations\Migration as BaseMigration;

class Migration extends BaseMigration
{
    /**
     * Use the connection specified in config.
     */
    public function getConnection(): ?string
    {
        if ($connection = config('employee-management.database.connection')) {
            return $connection;
        }

        return parent::getConnection();
    }
}
