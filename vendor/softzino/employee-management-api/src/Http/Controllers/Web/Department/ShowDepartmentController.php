<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Department;


//use App\Models\User;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Inertia\ResponseFactory;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagementApi\Http\Resource\DepartmentResource;

class ShowDepartmentController extends Controller
{
    public function __invoke(Request $request, $id): Response|ResponseFactory
    {

        // Retrieve the department using the getById method
        $department = DepartmentManagement::getById((int)$id, [
            'with' => ['designations', 'head', 'employees'],
        ]);


        if (!$department) {
            abort(404, 'Department not found');
        }

        // Format the department head
        $departmentHead = $department->head
            ? [
                'id' => $department->head->id,
                'name' => $department->head?->fullname,
                'designation' => $department->head?->employee->designation->name ?? null,
            ]
            : null;
        if (!$department) {
            abort(404, 'Department not found');
        }

        // Format the department head
        $departmentHead = $department->head
            ? [
                'id' => $department->head->id,
                'name' => $department->head?->fullname,
                'designation' => $department->head?->employee->designation->name ?? null,
                'employee_no' => $department->head?->employee->employee_no ?? null,
            ]
            : null;

        // Format the designations
        $designations = $department->designations->map(fn($designation) => [
            'id' => $designation->id,
            'name' => $designation->name,
            'employee_count' => $designation->employees->count(),
        ]);

        // Format the employees
        $employees = $department->employees->map(fn($employee) => [
            'id' => $employee->id,
            'name' => $employee->fullName,
            'designation' => '',
        ]);
        // Prepare the formatted department data
        $formattedDepartment = [
            'id' => $department->id,
            'name' => $department->name,
            'is_active' => $department->is_active,
            'created_by' => $department->created_by,
            'updated_by' => $department->updated_by,
            'department_head' => $departmentHead,
            'designations' => $designations,
            'employees' => $employees,
            'last_modified_at' => $department->updated_at,
        ];

        // Retrieve all departments
        $departments = DepartmentManagement::all([
            'with' => ['head'],
            'withCount' => ['designations', 'employees'],
            'orderBy' => ['id', 'desc']
        ]);

        $departmentResources = DepartmentResource::collection($departments)->resolve();

        // Retrieve employees data for dropdown/select options
        $employeeOptions = Employee::select("id as value", DB::raw("CONCAT(first_name, ' ', last_name) as label"))->get();

        return Inertia::render('Department/Index', [
            'departments' => $departmentResources,
            'employees' => $employeeOptions,
            'department' => $formattedDepartment,
        ]);
    }
}
