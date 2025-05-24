<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Department;

use Illuminate\Http\RedirectResponse;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagementApi\Http\Requests\CreateDepartmentRequest;

class StoreDepartmentController extends Controller
{
    /**
     * Handle the incoming request to store a new department.
     *
     * @param CreateDepartmentRequest $request
     * @return RedirectResponse
     */
    public function __invoke(CreateDepartmentRequest $request): RedirectResponse
    {
        // Add the authenticated user ID as the creator
        $departmentData = array_merge($request->validated(), [
            'created_by' => auth()->id() ?? 1,
            'created_by_name' => 'Admin'
        ]);

        // Create the department
        DepartmentManagement::create($departmentData);

        // Redirect to the index page with a success message
        return redirect()
            ->route('departments.index')
            ->with('success', 'Department created successfully!');
    }
}
