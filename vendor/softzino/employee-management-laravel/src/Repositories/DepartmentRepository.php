<?php

namespace Softzino\EmployeeManagement\Repositories;

use Softzino\EmployeeManagement\Contracts\Repositories\DepartmentRepositoryInterface;
use Softzino\EmployeeManagement\Models\Department;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    public function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function toggleStatus(Department $department): bool
    {
        $department->is_active = ! $department->is_active;

        return $department->save();
    }
}
