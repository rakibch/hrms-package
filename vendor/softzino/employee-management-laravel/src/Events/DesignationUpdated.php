<?php

namespace Softzino\EmployeeManagement\Events;

use Illuminate\Queue\SerializesModels;
use Softzino\EmployeeManagement\Models\Designation;

class DesignationUpdated
{
    use SerializesModels;

    public Designation $designation;

    /**
     * Create a new event instance.
     */
    public function __construct(Designation $designation)
    {
        $this->designation = $designation;
    }
}
