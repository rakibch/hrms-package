<?php
namespace Softzino\EmployeeManagementApi\Services;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Facades\DepartmentManagement;
use Illuminate\Support\Collection;
class DepartmentService{
    public function getAllDepartment(): Collection
    {
        return DepartmentManagement::all();
    }

    public function getDepartmentById(int $id): Department
    {
        return DepartmentManagement::getById($id);
    }

    public function createDepartment(array $data): Department
    {
        return DepartmentManagement::create($data);
    }

    public function updateDepartment(Department $department, array $data): Department
    {
        return DepartmentManagement::update($department, $data);
    }

    public function deleteDepartment(Department $department): bool
    {
        return DepartmentManagement::delete($department);
    }

    public function changeDepartmentStatus(Department $department, bool $status): Department
    {
        return DepartmentManagement::changeStatus($department, $status);
    }

    public function departmentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return DepartmentManagement::query();
    }
}

