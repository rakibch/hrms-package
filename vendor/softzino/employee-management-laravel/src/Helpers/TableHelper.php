<?php

namespace Softzino\EmployeeManagement\Helpers;

use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Models\Designation;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagement\Models\EmployeeContact;

class TableHelper
{
    public static function getDepartmentTable(): string
    {
        return (new Department)->getTable();
    }

    public static function getDesignationTable(): string
    {
        return (new Designation)->getTable();
    }

    public static function getEmployeeContactTable(): string
    {
        return (new EmployeeContact)->getTable();
    }

    public static function getEmployeeTable(): string
    {
        return (new Employee)->getTable();
    }
}
