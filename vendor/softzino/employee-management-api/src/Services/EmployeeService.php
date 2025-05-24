<?php

namespace Softzino\EmployeeManagementApi\Services;

use Illuminate\Support\Collection;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;

class EmployeeService
{
    /**
     * Get all employees from the core package using the facade.
     *
     * @return Collection
     */
    public function getAllEmployees(): Collection
    {
        // Use the core package facade to get all employees
        return EmployeeManagement::all();
    }

    /**
     * Get a specific employee by ID from the core package using the facade.
     *
     * @param int $id
     * @return Employee|null
     */
    public function getEmployeeById(int $id): ?Employee
    {
        // Use the core package facade to get an employee by ID
        return EmployeeManagement::getById($id);
    }

    /**
     * Create a new employee using the core package facade.
     *
     * @param array $data
     * @return Employee
     */
    public function createEmployee(array $data): Employee
    {
        // Use the core package facade to create an employee
        return EmployeeManagement::create($data);
    }

    /**
     * Update an existing employee using the core package facade.
     *
     * @param Employee $employee
     * @param array $data
     * @return Employee
     */
    public function updateEmployee(Employee $employee, array $data): Employee
    {
        // Use the core package facade to update an employee
        return EmployeeManagement::update($employee, $data);
    }

    /**
     * Delete an employee using the core package facade.
     *
     * @param Employee $employee
     * @return bool
     */
    public function deleteEmployee(Employee $employee): bool
    {
        // Use the core package facade to delete an employee
        return EmployeeManagement::delete($employee);
    }

    /**
     * Get filtered employees based on provided filters.
     *
     * @param array $filters
     * @return Collection
     */
    public function getFilteredEmployees(array $filters): Collection
    {
        // Use the core package facade to get employees by filters
        return EmployeeManagement::getFilteredEmployees($filters);
    }

    /**
     * Change the status of an employee using the core package facade.
     *
     * @param Employee $employee
     * @param string $status
     * @return Employee
     */
    public function changeEmployeeStatus(Employee $employee, string $status): Employee
    {
        // Use the core package facade to change the employee's status
        return EmployeeManagement::changeStatus($employee, $status);
    }

    /**
     * Get the employment history of an employee.
     *
     * @param int $employeeId
     * @return EmploymentHistory|null
     */
    public function getEmployeeHistory(int $employeeId)
    {
        // Use the core package facade to get the employment history of an employee
        return EmployeeManagement::getEmploymentHistoryRecord($employeeId);
    }
}
