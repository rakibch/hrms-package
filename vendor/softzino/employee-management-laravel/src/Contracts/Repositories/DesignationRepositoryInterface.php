<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Softzino\EmployeeManagement\Models\Designation;

interface DesignationRepositoryInterface extends BaseRepositoryInterface
{
    public function toggleStatus(Designation $designation): bool;
}
