<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Department;;

use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagement\Models\Department;

class ToggleDepartmentStatusController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(int $departmentId): RedirectResponse
    {
        $department = Department::findOrFail($departmentId);
        $statusUpdated = DepartmentManagement::toggleStatus($department);

        if ($statusUpdated) {
            return redirect()
                ->route('departments.index')
                ->with('success', 'Department status updated successfully!');
        }

        return redirect()
            ->route('departments.index')
            ->with('error', 'Failed to update department status.');
    }
}
