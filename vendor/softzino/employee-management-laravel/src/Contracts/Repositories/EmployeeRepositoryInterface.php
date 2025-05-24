<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Softzino\EmployeeManagement\Models\Address;
use Softzino\EmployeeManagement\Models\Employee;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function changeStatus(Employee $employee, string $status): Employee;

    public function createOfficialInformation(Employee $employee, array $data, int $employeeId): Employee;

    public function createWorkLocation(Employee $employee, array $data, int $employeeId): Address;

    public function updateWorkLocationAddressStatus(Employee $employee, int $employeeId): Employee;

    public function createAchievementEducation(Employee $employee, array $data, int $employeeId): bool;

    public function createAchievementProfExperience(Employee $employee, array $data, int $employeeId): bool;

    public function createAchievementCertificate(Employee $employee, array $data, int $employeeId): bool;

    public function getFilteredEmployees(array $filters);

    public function employeeHistoryRecord(Employee $employee, string $status, string $remarks): bool;

    public function getEmploymentHistoryRecord(int $employeeId): array;
}
