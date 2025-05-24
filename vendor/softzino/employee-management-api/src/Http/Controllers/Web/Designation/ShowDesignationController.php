<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation;

use Inertia\Response;
use Inertia\Inertia;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Softzino\EmployeeManagementApi\Http\Resources\DesignationResource;

class ShowDesignationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $id): Response
    {
        $designations = DesignationManagement::all(['orderBy' => ['id', 'desc'], 'with'=> ['departments', 'reportingTo']]);
        $designationResources = DesignationResource::collection($designations)->resolve();

        $designation = DesignationManagement::getById($id, ['department', 'reportingTo', 'employees']);

        if (!$designation) {
            abort(404, 'Designation not found');
        }


        // Format the supervisor information
        $supervisor = [
            'id' => $designation->reportingTo?->id,
            'name' => $designation->reportingTo?->name,
        ];

        // Format the employees information
        $employees = $designation->employees->map(fn ($employee) => [
            'id' => $employee->id,
            'name' => $employee->fullName,
            'designation' => $employee->designation->name,
        ]);

        // Prepare the formatted designation data
        $formattedDesignation = [
            'id' => $designation->id,
            'name' => $designation->name,
            'departments' => $designation->departments->map(fn ($department) => [
                'id' => $department->id,
                'name' => $department->name,
            ]),
            'supervisor' => $supervisor,
            'employees' => $employees,
            'total_employees' => $employees->count(),
            'last_modified_at' => $designation->updated_at,
            'is_active' => $designation->is_active ? 'Active' : 'Inactive',
        ];

        $namespace = config('employee-management.namespaces');
        return Inertia::render("{$namespace}::Designation/Index", [
            'data' => [
                'designations' => $designationResources,
                'departments' => DepartmentManagement::all(),
                'designation' => $formattedDesignation,
            ]
        ]);
    }
}
