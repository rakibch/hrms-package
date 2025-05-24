<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeAddressRepositoryInterface;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagement\Models\Country;

class View extends Controller
{
    protected EmployeeAddressRepositoryInterface $employeeAddressRepository;

    public function __construct(EmployeeAddressRepositoryInterface $employeeAddressRepository)
    {
        $this->employeeAddressRepository = $employeeAddressRepository;
    }

    public function __invoke(Request $request,string $id)
    {
        $employee = EmployeeManagement::getById($id, [
            'with' => ['contacts']
        ]);

        if (!$employee) {
            return redirect()->route('employee.index')->with('error', 'Employee not found.');
        }

        $presentAddress = $this->employeeAddressRepository->getAddress($employee, 'present');
        $permanentAddress =  $this->employeeAddressRepository->getAddress($employee, 'permanent');
        $workLocation = $employee->addresses->where('type', 'worklocation')->first();

        $department =$employee->department()->first()->name??'-';
        $designation =$employee->designation()->first()->name??'-';

        $educationalInformation = $employee->educationalInformations;
        $certificationInformation = $employee->certifications;

        $professionalInformation = $employee->professionalExperiences->isNotEmpty()
            ? $employee->professionalExperiences->map(function ($profExperience) {
                return [
                    'institution_name' => $profExperience->institution_name ?? '',
                    'designation' => $profExperience->designation ?? '-',
                    'start_date' => $profExperience->formatted_start_date ?? '0000-00-00',
                    'end_date' => $profExperience->is_running ? 'Running' : ($profExperience->formatted_end_date ?? '0000-00-00'),
                ];
            })->toArray()
            : [];

        $data = [
            'id' => $id,
            'full_name'=>$employee->full_name,
            'profile_image'=>$employee->profile_image ?? '',
            'join_date'=>$employee->join_date??'0000-00-00',
            'employee_no'=>$employee->employee_no??'-',
            'job_type'=>$employee->job_type??'-',
            'department'=>$department,
            'designation'=>$designation,
            'employment_type'=>$employee->employment_type??'-',
        ];

        $basicInformation = [
            'dob'=>$employee->dob??'0000-00-00',
            'gender'=>$employee->gender??'-',
            'religion'=>$employee->religion??'-',
            'blood_group'=>$employee->blood_group??'-',
            'father_name'=>$employee->father_name??'-',
            'mother_name'=>$employee->mother_name??'-',
            'marital_status'=>$employee->marital_status??'-',
            'personal_contact_no'=>$employee->personal_contact_no??'-',
            'personal_email'=>$employee->personal_email??'-',
            'present_state'=> $presentAddress->state??'-',
            'present_street_address'=> $presentAddress->street??'-',
            'present_city'=> $presentAddress->city??'-',
            'present_postal_code'=> $presentAddress->postal_code??'-',
            'present_country'=> $presentAddress->countryRelation?->name ?? '-',
            'permanent_state'=> $permanentAddress->state??'-',
            'permanent_street_address'=> $permanentAddress->street??'-',
            'permanent_city'=> $permanentAddress->city??'-',
            'permanent_postal_code'=> $permanentAddress->postal_code??'-',
            'permanent_country'=> $permanentAddress->countryRelation?->name ?? '-',
            'contacts'=>$employee->contacts ?? [],
            'documents' => $employee->employeeDocuments->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'type' => $doc->document_type,
                    'url' => $doc->document_path,
                    'expiry_date' => $doc->expiry_date ?? '-',
                    'uploaded_at' => $doc->created_at->toDateTimeString(),
                ];
            })->toArray(),
        ];

        $officialInformation = [
            'official_department'=>$department,
            'official_designation'=>$designation,
            'official_employment_type'=>$employee->employment_type??'-',
            'official_contact_no'=>$employee->official_contact_no??'-',
            'official_email'=>$employee->official_email??'-',
            'official_job_type'=>$employee->job_type??'-',
        ];
        $workLocationInfo = [
            'work_location_country'=> $workLocation->country??'-',
            'work_location_city'=> $workLocation->city??'-',
            'work_location_state'=> $workLocation->state??'-',
            'work_location_postal_code'=> $workLocation->postal_code??'-',
            'work_location_street'=> $workLocation->street??'-',
        ];

        $countries = Country::select('id', 'name')->get();


        $namespace = config('employee-management.namespaces');
        return Inertia::render("{$namespace}::Employee/View",[
            'singleEmployee' => $data,
            'basicInformation' => $basicInformation,
            'officialInformation' => $officialInformation,
            'workLocationInformation' => $workLocationInfo,
            'professionalExperienceInformation' => $professionalInformation,
            'educationalInformation' => $educationalInformation,
            'certificationInformation' => $certificationInformation,
            'countries' => $countries,
        ]);
    }
}
