<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Department;

use Illuminate\Http\RedirectResponse;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagementApi\Http\Requests\UpdateDepartmentRequest;

class UpdateDepartmentController extends Controller
{
    /**
     * Handle the update request for a department.
     *
     * @param UpdateDepartmentRequest $request
     * @param Department $department
     * @return RedirectResponse
     */
    public function __invoke(UpdateDepartmentRequest $request, Department $department,$departmentId): RedirectResponse
    {
       $department = Department::findOrFail($departmentId);

        // Update the department using validated data
        DepartmentManagement::update($department, $request->validated());

        // Redirect with success message
        return redirect()
            ->route('departments.index')
            ->with('success', 'Department updated successfully!');
    }
}
