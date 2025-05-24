<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Softzino\EmployeeManagement\Models\Country;

class Create extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $designations = DesignationManagement::all();
        $departments = DepartmentManagement::all();
        $countries = Country::select('id', 'name', 'iso2_code', 'phone_code')->get();

        $namespace = config('employee-management.namespaces');
        return Inertia::render("{$namespace}::Employee/Create", [
            'designations' => $designations,
            'departments' => $departments,
            'countries' => $countries,
        ]);
    }
}
