<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Models\EmploymentHistory;

interface EmploymentHistoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getByEmployeeId(int $employeeId): Collection;

    public function getActiveHistory(int $employeeId): ?EmploymentHistory;
}
