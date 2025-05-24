<?php
namespace Softzino\EmployeeManagementApi\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Softzino\EmployeeManagementApi\Services\EmployeeService;
class EmployeeController extends Controller
{
    protected $employeeService;
    // Inject EmployeeService into the controller
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Get all employees.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Call the service to get all employees
        $employees = $this->employeeService->getAllEmployees();

        return response()->json($employees);
    }

    /**
     * Get a specific employee by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        // Call the service to get an employee by ID
        $employee = $this->employeeService->getEmployeeById($id);

        return response()->json($employee);
    }

    /**
     * Change the status of an employee.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:active,inactive,resigned,terminated,goabroad,deceased',
        ]);

        $employee = $this->employeeService->getEmployeeById($id);
        $updatedEmployee = $this->employeeService->changeEmployeeStatus($employee, $request->status);

        return response()->json($updatedEmployee);
    }

}
