<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Contracts\Repositories\EmploymentHistoryRepositoryInterface;
use Softzino\EmployeeManagement\Models\EmploymentHistory;

class EmploymentHistoryRepository extends BaseRepository implements EmploymentHistoryRepositoryInterface
{
    public function __construct(EmploymentHistory $model)
    {
        parent::__construct($model);
    }

    /**
     * Get all employment histories for a specific employee.
     */
    public function getByEmployeeId(int $employeeId): Collection
    {
        return $this->model->where('employee_id', $employeeId)
            ->orderByDesc('start_date')
            ->get();
    }

    /**
     * Get the currently active employment history of an employee.
     */
    public function getActiveHistory(int $employeeId): ?EmploymentHistory
    {
        return $this->model->where('employee_id', $employeeId)
            ->where('status', 'active')
            ->latest('start_date')
            ->first();
    }
}
