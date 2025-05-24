<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

interface EmployeeContactsRepositoryInterface
{
    /**
     * Store contact details for a given employee.
     *
     * @param Model $employee The employee to associate the contact with.
     * @param array $contact  The contact data.
     */
    public function storeContact(Model $employee, array $contact): void;

    /**
     * Update an existing employee contact.
     *
     * @param int   $contactId The contact ID.
     * @param array $contact   The updated contact data.
     */
    public function updateContact(int $contactId, array $contact): bool;

    /**
     * Delete an employee contact.
     *
     * @param int $contactId The contact ID.
     */
    public function deleteContact(int $contactId): bool;
}
