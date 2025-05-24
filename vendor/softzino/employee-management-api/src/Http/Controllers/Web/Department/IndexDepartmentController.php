<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Department;

use Illuminate\Routing\Controller;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagementApi\Http\Resource\DepartmentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;

class IndexDepartmentController extends Controller
{
    public function __invoke(Request $request)
    {
        $departments = DepartmentManagement::all([
            'with' => ['head'],
            'withCount' => ['designations', 'employees'],
            'orderBy' => ['id', 'desc']
        ]);
        $departmentResources = DepartmentResource::collection($departments)->resolve();
        $employees = Employee::where('employment_status', 'active')
            ->select("id as value", DB::raw("CONCAT(first_name,' ',last_name) as label"))
            ->get();

        $namespace = config('employee-management.namespaces');
        return Inertia::render("{$namespace}::Department/Index", [
            'departments' => Inertia::merge(fn() => $departmentResources),
            'employees' => $employees,
        ]);
    }
}
