<?php

namespace Softzino\EmployeeManagement\Events;

use Illuminate\Queue\SerializesModels;
use Softzino\EmployeeManagement\Models\Employee;

class EmployeeUpdated
{
    use SerializesModels;

    public Employee $employee;

    /**
     * Create a new event instance.
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }
}
