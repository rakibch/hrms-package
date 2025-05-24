<?php

namespace Softzino\EmployeeManagement\Base;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = config('employee-management.database.connection');
    }

    public static function getTableName(): string
    {
        return app(static::class)->getTable();
    }
}
