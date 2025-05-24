<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;

class Timeline extends Controller
{
    public function __invoke(Request $request,int $id): Response
    {
        $employee = EmployeeManagement::getById($id);
        $department =$employee->department()->first()->name??'-';
        $designation =$employee->designation()->first()->name??'-';
        $data = [
            'id' => $id,
            'full_name'=>$employee->fullName,
            'join_date'=>$employee->join_date??'0000-00-00',
            'employee_no'=>$employee->employee_no??'-',
            'job_type'=>$employee->job_type??'-',
            'department'=>$department,
            'designation'=>$designation,
            'employment_type'=>$employee->employment_type??'-',
        ];
        $timelineRecords = EmployeeManagement::getEmploymentHistoryRecord($id);
        return Inertia::render('EmployeeManagement/Employee/TimeLine',[
            'singleEmployee' => $data,
            'timelineRecords' => $timelineRecords,
        ]);
    }
}
