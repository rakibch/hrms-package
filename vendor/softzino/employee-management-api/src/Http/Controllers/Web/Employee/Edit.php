<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee;


use Inertia\Inertia;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;
use Softzino\EmployeeManagement\Models\Country;
use Softzino\EmployeeManagementApi\Http\Resources\EmployeeEditResource;

class Edit
{
    public function __invoke(int $employeeId)
    {
        $employee = EmployeeManagement::getById($employeeId, [
            'with' => [
                'addresses',
                'contacts',
                'employeeDocuments',
                'educationalInformations',
                'professionalExperiences',
                'certifications',
            ],
        ]);
        $workLocation = $employee?->addresses()?->where('type', 'worklocation')->first();

        $namespace = config('employee-management.namespaces');
        return Inertia::render("{$namespace}::Employee/Create", [
            'employee'     => new EmployeeEditResource($employee),
            'designations' => DesignationManagement::all(),
            'departments'  => DepartmentManagement::all(),
            'countries'    => Country::select('id', 'name', 'iso2_code', 'phone_code')->get(),
            'work_location' => $workLocation,
        ]);
    }
}
