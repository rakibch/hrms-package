<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;

class UpdateStatus extends Controller
{
    public function __invoke(Request $request,string $id)
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive,resigned,terminated,goabroad,deceased',
            'remarks' => 'nullable|string',
        ]);
        $employee = Employee::findOrFail($id);
        EmployeeManagement::changeStatus($employee, $request->status);
        EmployeeManagement::employeeHistoryRecord($employee,$request->status,$request->remarks ?: '');

        return redirect()->route('employee.index')->with(['success' => 'Employee status has been updated.']);
    }
}
