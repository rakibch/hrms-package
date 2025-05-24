<?php
namespace Softzino\EmployeeManagementApi\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Softzino\EmployeeManagementApi\Models\Employee;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return Inertia::render('Employees/Index', [
            'employees' => $employees
        ]);
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return Inertia::render('Employees/Show', [
            'employee' => $employee
        ]);
    }

    public function updateStatus($id)
    {
        // Your update logic
    }
}
