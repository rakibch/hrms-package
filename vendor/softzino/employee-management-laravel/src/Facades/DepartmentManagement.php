<?php

namespace Softzino\EmployeeManagement\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Repositories\DepartmentRepository;

/**
 * @see DepartmentRepository
 *
 * @method static Builder    query()
 * @method static Department create(array $data)
 * @method static Department update(Department $department, array $data)
 * @method static bool       delete(Department $department)
 * @method static Collection all()
 * @method static Department getById(int $id)
 * @method static Department toggleStatus(Department $department)
 */
class DepartmentManagement extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DepartmentRepository::class;
    }
}
