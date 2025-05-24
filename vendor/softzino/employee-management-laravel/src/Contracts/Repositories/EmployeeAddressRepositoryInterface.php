<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface EmployeeAddressRepositoryInterface
{
    /**
     * Store an address for a given model.
     *
     * @param Model      $addressable The model to associate the address with.
     * @param string     $type        The type of address (e.g., 'present', 'permanent', 'worklocation').
     * @param array|null $address     The address data.
     */
    public function storeAddress(Model $addressable, string $type, ?array $address): void;

    /**
     * Update an address of a given type for a model.
     */
    public function updateAddress(Model $addressable, string $type, ?array $address): void;

    /**
     * Delete an address of a given type or all if type is null.
     */
    public function deleteAddress(Model $addressable, ?string $type = null): void;

    /**
     * Get a specific type of address for a model.
     */
    public function getAddress(Model $addressable, string $type): ?Model;

    /**
     * Get all addresses for a model.
     */
    public function getAllAddresses(Model $addressable): Collection;
}
