<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Models\ProfessionalExperience;

interface EmployeeProfessionalExperienceRepositoryInterface
{
    public function storeExperience(int $employeeId, array $experienceData): ProfessionalExperience;

    public function updateExperience(ProfessionalExperience $experience, array $experienceData): bool;

    public function deleteExperience(ProfessionalExperience $experience): bool;

    public function getEmployeeExperiences(int $employeeId): Collection;
}
