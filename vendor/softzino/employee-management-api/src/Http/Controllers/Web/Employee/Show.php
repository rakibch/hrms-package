<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeAddressRepositoryInterface;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagementApi\Http\Resource\EmployeeResource;

class Show extends Controller
{
    protected EmployeeAddressRepositoryInterface $employeeAddressRepository;

    public function __construct(EmployeeAddressRepositoryInterface $employeeAddressRepository)
    {
        $this->employeeAddressRepository = $employeeAddressRepository;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id): Response
    {
        $employees = EmployeeManagement::all([
            'with' => ['department', 'designation']
        ]);

        $id = (int)$id;
        $employeeResources = EmployeeResource::collection($employees)->resolve();
        $employee = EmployeeManagement::getById($id);

        $address = $this->employeeAddressRepository->getAddress($employee, 'present');

        $department = $employee->department()->first()->name ?? '-';
        $designation = $employee->designation()->first()->name ?? '-';

        $data = [
            'id' => $id,
            'fullName' => $employee->fullName,
            'profile_image' => $employee->profile_image ?? '',
            'joinDate' => $employee->join_date ?? '0000-00-00',
            'employeeNo' => $employee->employee_no ?? '-',
            'jobType' => $employee->job_type ?? '-',
            'department' => $department,
            'designation' => $designation,
            'employmentType' => $employee->employment_type ?? '-',
        ];

        $basicInformation = [
            'dob' => $employee->dob ?? '0000-00-00',
            'gender' => $employee->gender ?? '-',
            'religion' => $employee->religion ?? '-',
            'bloodGroup' => $employee->blood_group ?? '-',
            'fatherName' => $employee->father_name ?? '-',
            'motherName' => $employee->mother_name ?? '-',
            'maritalStatus' => $employee->marital_status ?? '-',
            'spouseName' => $employee->spouse_name ?? '-',
            'personalContactNo' => $employee->personal_contact_no ?? '-',
            'personalEmail' => $employee->personal_email ?? '-',
            'presentState' => $address->state ?? '-',
            'presentStreetAddress' => $address->street ?? '-',
            'presentCity' => $address->city ?? '-',
            'presentPostalCode' => $address->postal_code ?? '-',
            'presentCountry' => $address->countryRelation?->name ?? '-',
        ];

        $namespace = config('employee-management.namespaces');

        return Inertia::render("{$namespace}::Employee/Index", [
            'singleEmployee' => $data,
            'basicInformation' => $basicInformation,
            'employees' => $employeeResources,
        ]);
    }
}
