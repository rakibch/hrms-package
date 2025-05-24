<?php

namespace Softzino\EmployeeManagementApi\Services;

use Illuminate\Support\Collection;
use Softzino\EmployeeManagement\Facades\DesignationManagement;
use Softzino\EmployeeManagement\Models\Designation;

class DesignationService
{
    /**
     * Fetches all designations from the DesignationManagement system.
     *
     * @return Collection The list of all designations.
     */
    public function getAllDesignations(): Collection
    {
       return DesignationManagement::all();
    }

    /**
     * Get a specific designation by ID from the core package using the facade.
     *
     * @param int $id
     * @return Designation
     */
    public function getDesignationById(int $id): Designation
    {
        // Use the core package facade to get an designation by ID
        return DesignationManagement::getById($id);
    }

    /**
     * Create a new Designation using the core package facade.
     *
     * @param array $data
     * @return Designation
     */
    public function createDesignation(array $data): Designation
    {
        // Use the core package facade to create an designation
        return DesignationManagement::create($data);
    }

    /**
     * Update an existing Designation using the core package facade.
     *
     * @param Designation $designation
     * @param array $data
     * @return Designation
     */
    public function updateDesignation(Designation $designation, array $data): Designation
    {
        // Use the core package facade to update an designation
        return DesignationManagement::update($designation, $data);
    }

    /**
     * Delete an designation using the core package facade.
     *
     * @param Designation $designation
     * @return bool
     */
    public function deleteDesignation(Designation $designation): bool
    {
        // Use the core package facade to delete an designation
        return DesignationManagement::delete($designation);
    }

    /**
     * Change the status of a designation using the core package facade.
     *
     * @param int $id
     * @return bool
     */
    public function toggleStatus(int $id): bool
    {
        return DesignationManagement::toggleStatus($this->getDesignationById($id));
    }
}
