<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation;

use Inertia\Response;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Inertia\Inertia;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagementApi\Http\Resources\DesignationResource;

class IndexDesignationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): Response
    {
        $designations = DesignationManagement::all([
            'orderBy' => ['id', 'desc'],
            'with'=> ['departments', 'reportingTo'],
        ]);

        $designationResources = DesignationResource::collection($designations)->resolve();

        $namespace = config('employee-management.namespaces');
        return Inertia::render("{$namespace}::Designation/Index", [
            'data' => [
                'designations' => $designationResources,
                'departments' => DepartmentManagement::all(),
            ]
        ]);
    }
}
