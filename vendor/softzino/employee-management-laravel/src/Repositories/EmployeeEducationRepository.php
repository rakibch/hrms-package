<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeEducationRepositoryInterface;
use Softzino\EmployeeManagement\Models\EducationalInformation;

class EmployeeEducationRepository implements EmployeeEducationRepositoryInterface
{
    public function storeEducation(int $employeeId, array $educationData): EducationalInformation
    {
        $educationData['employee_id'] = $employeeId;

        return EducationalInformation::create($educationData);
    }

    public function updateEducation(EducationalInformation $education, array $educationData): bool
    {
        return $education->update($educationData);
    }

    public function deleteEducation(EducationalInformation $education): bool
    {
        return $education->delete();
    }

    public function getEmployeeEducations(int $employeeId): Collection
    {
        return EducationalInformation::where('employee_id', $employeeId)->get();
    }
}
