<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation;

use Illuminate\Http\RedirectResponse;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Softzino\EmployeeManagement\Models\Designation;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagementApi\Http\Requests\Designation\UpdateRequest;

class UpdateDesignationController extends Controller
{
    /**
     * Handle the update request for a designation.
     *
     * @param UpdateRequest $request
     * @param Designation $designation
     * @param int $designationId
     * @return RedirectResponse
     */
    public function __invoke(UpdateRequest $request, Designation $designation, $designationId): RedirectResponse
    {
        // Find the designation by ID or fail if not found
        $designation = Designation::findOrFail($designationId);

        // Get the validated data
        $designationData = $request->validated();

        // Extract the departments
        $departments = $designationData['departments'] ?? [];
        unset($designationData['departments']); // Remove departments from the data to update other fields

        // Update the designation using validated data
        DesignationManagement::update($designation, $designationData);

        // Sync departments if provided
        if (!empty($departments)) {
            // Sync the departments (if any)
            $designation->departments()->sync($departments);
        } else {
            // Detach all departments if no departments are provided
            $designation->departments()->detach();
        }

        // Redirect with success message
        return redirect()
            ->route('designations.index')
            ->with('success', 'Designation updated successfully!');
    }
}
