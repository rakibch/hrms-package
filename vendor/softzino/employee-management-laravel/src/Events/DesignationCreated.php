<?php

namespace Softzino\EmployeeManagement\Events;

use Illuminate\Queue\SerializesModels;
use Softzino\EmployeeManagement\Models\Designation;

class DesignationCreated
{
    use SerializesModels;

    public Designation $designation;

    public function __construct(Designation $designation)
    {
        $this->designation = $designation;
    }
}
