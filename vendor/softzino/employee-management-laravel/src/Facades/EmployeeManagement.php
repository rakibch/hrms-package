<?php

namespace Softzino\EmployeeManagement\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;
use Softzino\EmployeeManagement\Models\Certification;
use Softzino\EmployeeManagement\Models\EducationalInformation;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagement\Models\EmploymentHistory;
use Softzino\EmployeeManagement\Models\ProfessionalExperience;
use Softzino\EmployeeManagement\Repositories\EmployeeRepository;

/**
 * @see EmployeeRepository
 *
 * @method static Builder                query()
 * @method static Employee               create(array $data)
 * @method static Employee               update(Employee $employee, array $data)
 * @method static bool                   delete(Employee $employee)
 * @method static Collection             all()
 * @method static Employee               getById(int $id)
 * @method static Employee               changeStatus(Employee $employee, string $status)
 * @method static Employee               createOfficialInformation(Employee $employee, array $data, int $employeeId)
 * @method static Employee               createWorkLocation(Employee $employee, array $data, int $employeeId)
 * @method static Employee               updateWorkLocationAddressStatus(Employee $employee, int $employeeId)
 * @method static EducationalInformation createAchievementEducation(Employee $employee,array $data, int $employeeId)
 * @method static ProfessionalExperience createAchievementProfExperience(Employee $employee,array $data, int $employeeId)
 * @method static Certification          createAchievementCertificate(Employee $employee,array $data, int $employeeId)
 * @method static Employee               getFilteredEmployees(array $filters)
 * @method static EmploymentHistory      employeeHistoryRecord(Employee $employee,string $status, string $remarks)
 * @method static EmploymentHistory      getEmploymentHistoryRecord(int $employeeId)
 */
class EmployeeManagement extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return EmployeeRepository::class;
    }
}
