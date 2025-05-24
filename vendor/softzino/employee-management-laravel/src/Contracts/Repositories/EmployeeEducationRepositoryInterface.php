<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Models\EducationalInformation;

interface EmployeeEducationRepositoryInterface
{
    public function storeEducation(int $employeeId, array $educationData): EducationalInformation;

    public function updateEducation(EducationalInformation $education, array $educationData): bool;

    public function deleteEducation(EducationalInformation $education): bool;

    public function getEmployeeEducations(int $employeeId): Collection;
}
