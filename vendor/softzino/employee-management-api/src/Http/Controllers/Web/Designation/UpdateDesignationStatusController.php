<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Designation;

use Illuminate\Http\RedirectResponse;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Softzino\EmployeeManagement\Models\Designation;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;

class UpdateDesignationStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Designation $designation, $designationId): RedirectResponse
    {
        // Find the designation by ID or fail if not found
        $designation = Designation::findOrFail($designationId);

        $statusUpdated = DesignationManagement::toggleStatus($designation);

        if ($statusUpdated) {
            return redirect()
                ->route('designations.index')
                ->with('success', 'Designation status updated successfully!');
        }

        return redirect()
            ->route('designations.index')
            ->with('error', 'Failed to update designation status.');
    }
}
