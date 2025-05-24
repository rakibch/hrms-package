<?php

namespace Softzino\EmployeeManagement\Facades;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;
use Softzino\EmployeeManagement\Models\Designation;
use Softzino\EmployeeManagement\Repositories\DesignationRepository;

/**
 * @see DesignationRepository
 *
 * @method static Builder     query()
 * @method static Designation create(array $data)
 * @method static Designation update(Designation $designation, array $data)
 * @method static bool        delete(Designation $designation)
 * @method static Collection  all(array $relations = [])
 * @method static Designation getById(int $id, ?array $relations = null)
 * @method static Designation changeStatus(Designation $designation, bool $status)
 */
class DesignationManagement extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return DesignationRepository::class;
    }
}
