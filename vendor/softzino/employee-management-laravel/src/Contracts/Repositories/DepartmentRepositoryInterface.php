<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Softzino\EmployeeManagement\Models\Department;

interface DepartmentRepositoryInterface extends BaseRepositoryInterface
{
    public function toggleStatus(Department $department): bool;
}
