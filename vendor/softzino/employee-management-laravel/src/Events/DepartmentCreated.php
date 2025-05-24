<?php

namespace Softzino\EmployeeManagement\Events;

use Illuminate\Queue\SerializesModels;
use Softzino\EmployeeManagement\Models\Department;

class DepartmentCreated
{
    use SerializesModels;

    public Department $department;

    public function __construct(Department $department)
    {
        $this->department = $department;
    }
}
