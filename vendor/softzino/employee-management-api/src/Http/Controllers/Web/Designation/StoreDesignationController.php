<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation;

use Illuminate\Http\RedirectResponse;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Softzino\EmployeeManagement\Models\DepartmentDesignation;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagementApi\Http\Requests\Designation\CreateRequest;
use Illuminate\Support\Facades\DB;

class StoreDesignationController extends Controller
{
    /**
     * Handle the incoming request to store a new designation.
     *
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function __invoke(CreateRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            // Prepare data
            $designationData = array_merge($request->validated(), [
                'created_by' => auth()->id() ?? 1, //TODO: replace with actual user ID
                'created_by_name' => 'Admin', // TODO: replace with actual user name
            ]);

            // Extract departments if any
            $departments = $designationData['departments'] ?? [];
            unset($designationData['departments']);

            // Create the designation
            $designation = DesignationManagement::create($designationData);

            // Attach departments if provided
            foreach ($departments as $departmentId) {
                DepartmentDesignation::create([
                    'department_id' => $departmentId,
                    'designation_id' => $designation->id,
                ]);
            }
        });

        // Redirect to the index page with a success message
        return redirect()
            ->route('designations.index')
            ->with('success', 'Designation created successfully!');
    }
}
