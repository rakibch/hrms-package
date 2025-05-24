<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Models\Certification;

interface CertificationRepositoryInterface
{
    public function storeCertification(int $employeeId, array $certificationData): Certification;

    public function updateCertification(Certification $certification, array $certificationData): bool;

    public function deleteCertification(Certification $certification): bool;

    public function getEmployeeCertifications(int $employeeId): Collection;
}
