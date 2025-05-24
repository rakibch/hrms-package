<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Contracts\Repositories\CertificationRepositoryInterface;
use Softzino\EmployeeManagement\Models\Certification;

class CertificationRepository implements CertificationRepositoryInterface
{
    public function storeCertification(int $employeeId, array $certificationData): Certification
    {
        $certificationData['employee_id'] = $employeeId;

        return Certification::create($certificationData);
    }

    public function updateCertification(Certification $certification, array $certificationData): bool
    {
        return $certification->update($certificationData);
    }

    public function deleteCertification(Certification $certification): bool
    {
        return $certification->delete();
    }

    public function getEmployeeCertifications(int $employeeId): Collection
    {
        return Certification::where('employee_id', $employeeId)->get();
    }
}
