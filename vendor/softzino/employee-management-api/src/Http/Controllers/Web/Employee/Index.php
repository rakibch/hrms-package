<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee;

use Illuminate\Routing\Controller;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Softzino\EmployeeManagementApi\Http\Resource\EmployeeResource;

class Index extends Controller
{
    public function __invoke(Request $request): Response
    {
        $designations = DesignationManagement::all();
        $departments = DepartmentManagement::all();

        $employees = $request->all()
            ? EmployeeManagement::getFilteredEmployees($request->all())
            : EmployeeManagement::all([
                'with' => ['department', 'designation']
            ]);

        $employeeResources = EmployeeResource::collection($employees)->resolve();

        $namespace = config('employee-management.namespaces');

        return Inertia::render("{$namespace}::Employee/Index", [
            'employee' => $employeeResources,
            'designations' => $designations,
            'departments' => $departments,
        ]);
    }
}
