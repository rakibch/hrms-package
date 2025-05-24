<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeProfessionalExperienceRepositoryInterface;
use Softzino\EmployeeManagement\Models\ProfessionalExperience;

class EmployeeProfessionalExperienceRepository implements EmployeeProfessionalExperienceRepositoryInterface
{
    public function storeExperience(int $employeeId, array $experienceData): ProfessionalExperience
    {
        $experienceData['employee_id'] = $employeeId;

        return ProfessionalExperience::create($experienceData);
    }

    public function updateExperience(ProfessionalExperience $experience, array $experienceData): bool
    {
        return $experience->update($experienceData);
    }

    public function deleteExperience(ProfessionalExperience $experience): bool
    {
        return $experience->delete();
    }

    public function getEmployeeExperiences(int $employeeId): Collection
    {
        return ProfessionalExperience::where('employee_id', $employeeId)->get();
    }
}
