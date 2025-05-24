<?php

namespace Softzino\EmployeeManagement\Repositories;

use Softzino\EmployeeManagement\Contracts\Repositories\DesignationRepositoryInterface;
use Softzino\EmployeeManagement\Models\Designation;

class DesignationRepository extends BaseRepository implements DesignationRepositoryInterface
{
    public function __construct(Designation $model)
    {
        parent::__construct($model);
    }

    /**
     * Change the active status of a designation.
     */
    public function toggleStatus(Designation $designation): bool
    {
        $designation->is_active = ! $designation->is_active;

        return $designation->save();
    }
}
