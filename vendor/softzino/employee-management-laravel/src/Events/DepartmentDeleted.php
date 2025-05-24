<?php

namespace Softzino\EmployeeManagement\Events;

use Illuminate\Queue\SerializesModels;
use Softzino\EmployeeManagement\Models\Department;

class DepartmentDeleted
{
    use SerializesModels;

    public Department $department;

    /**
     * Create a new event instance.
     */
    public function __construct(Department $department)
    {
        $this->department = $department;
    }
}
