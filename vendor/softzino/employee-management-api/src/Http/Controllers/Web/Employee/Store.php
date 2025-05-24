<?php
namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Employee;

use Illuminate\Http\RedirectResponse;
use Softzino\EmployeeManagement\Repositories\EmployeeRepository;
use Softzino\EmployeeManagementApi\Http\Controllers\Controller;
use Softzino\EmployeeManagementApi\Http\Requests\Employee\StoreRequest;

class Store extends Controller
{
    protected EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Handle the request to store a new employee.
     */
    public function __invoke(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $userId = auth()->id() ?? 1; // TODO: Remove 1 when auth package is implemented

        try {
            $this->employeeRepository->createEmployee($validated, $userId);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create employee: ' . $e->getMessage()]);
        }

        $message = $validated['profile_status'] === 'draft'
            ? 'Employee draft saved successfully!'
            : 'Employee created successfully!';

        return redirect()
            ->route('employee.index')
            ->with('success', $message);
    }
}
