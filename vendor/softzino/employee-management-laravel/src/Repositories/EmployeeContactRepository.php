<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Database\Eloquent\Model;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeContactsRepositoryInterface;
use Softzino\EmployeeManagement\Models\EmployeeContact;

class EmployeeContactRepository implements EmployeeContactsRepositoryInterface
{
    protected EmployeeContact $model;

    public function __construct(EmployeeContact $model)
    {
        $this->model = $model;
    }

    public function storeContact(Model $employee, array $contact): void
    {
        if (empty(array_filter($contact))) {
            return;
        }

        $employee->contacts()->create([
            'name' => $contact['name'] ?? null,
            'relationship' => $contact['relationship'] ?? null,
            'contact_no' => $contact['contact_no'] ?? null,
            'street' => $contact['address']['street'] ?? null,
            'city' => $contact['address']['city'] ?? null,
            'state' => $contact['address']['state'] ?? null,
            'postal_code' => $contact['address']['postal_code'] ?? null,
            'country' => $contact['address']['country'] ?? null,
            'created_by' => auth()->id() ?? 1, // Todo: Replace with actual user ID
        ]);
    }

    public function updateContact(int $contactId, array $contact): bool
    {
        $employeeContact = $this->model->find($contactId);

        if (! $employeeContact) {
            return false;
        }

        return $employeeContact->update([
            'name' => $contact['name'] ?? $employeeContact->name,
            'relationship' => $contact['relationship'] ?? $employeeContact->relationship,
            'contact_no' => $contact['contact_no'] ?? $employeeContact->contact_no,
            'street' => $contact['street'] ?? $employeeContact->street,
            'city' => $contact['city'] ?? $employeeContact->city,
            'state' => $contact['state'] ?? $employeeContact->state,
            'postal_code' => $contact['postal_code'] ?? $employeeContact->postal_code,
            'country' => $contact['country'] ?? $employeeContact->country,
            'updated_by' => auth()->id(),
        ]);
    }

    public function deleteContact(int $contactId): bool
    {
        $employeeContact = $this->model->find($contactId);

        if (! $employeeContact) {
            return false;
        }

        return $employeeContact->delete();
    }
}
