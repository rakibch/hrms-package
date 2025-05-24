<?php

namespace Softzino\EmployeeManagementApi\Rules;

trait EmergencyContactRules
{
    /**
     * Get validation rules for emergency contact person information.
     */
    public function emergencyContactRules(): array
    {
        return [
            'emergency_contact.name' => ['nullable', 'string', 'max:255'],
            'emergency_contact.relationship' => ['nullable', 'string', 'max:50'],
            'emergency_contact.contact_no' => ['nullable', 'string', 'regex:/^\+?[0-9]{10,20}$/'],
            'emergency_contact.address.country' => ['nullable', 'numeric'],
            'emergency_contact.address.city' => ['nullable', 'string', 'max:100', 'min:2'],
            'emergency_contact.address.street_address' => ['nullable', 'string', 'max:255', 'min:2'],
            'emergency_contact.address.state' => ['nullable', 'string', 'max:100', 'min:2'],
            'emergency_contact.address.postal_code' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Get validation messages for emergency contact person information.
     */
    public function emergencyContactMessages(): array
    {
        return [
            // General information messages
            'emergency_contact.name.required' => 'The name of the emergency contact person is required.',
            'emergency_contact.name.max' => 'The name of the emergency contact person may not exceed 255 characters.',
            'emergency_contact.relationship.required' => 'The relationship of the emergency contact person is required.',
            'emergency_contact.relationship.max' => 'The relationship of the emergency contact person may not exceed 50 characters.',
            'emergency_contact.contact_no.required' => 'The contact number of the emergency contact person is required.',
            'emergency_contact.contact_no.regex' => 'The contact number of the emergency contact person must be a valid phone number.',

            // Address messages
            'emergency_contact.address.country.required' => 'The country for the emergency contact person\'s address is required.',
            'emergency_contact.address.country.max' => 'The country for the emergency contact person\'s address may not exceed 100 characters.',
            'emergency_contact.address.country.min' => 'The country for the emergency contact person\'s address must be at least 2 characters.',
            'emergency_contact.address.city.required' => 'The city for the emergency contact person\'s address is required.',
            'emergency_contact.address.city.max' => 'The city for the emergency contact person\'s address may not exceed 100 characters.',
            'emergency_contact.address.city.min' => 'The city for the emergency contact person\'s address must be at least 2 characters.',
            'emergency_contact.address.street_address.required' => 'The street address for the emergency contact person\'s address is required.',
            'emergency_contact.address.street_address.max' => 'The street address for the emergency contact person\'s address may not exceed 255 characters.',
            'emergency_contact.address.street_address.min' => 'The street address for the emergency contact person\'s address must be at least 2 characters.',
            'emergency_contact.address.state.required' => 'The state for the emergency contact person\'s address is required.',
            'emergency_contact.address.state.max' => 'The state for the emergency contact person\'s address may not exceed 100 characters.',
            'emergency_contact.address.state.min' => 'The state for the emergency contact person\'s address must be at least 2 characters.',
            'emergency_contact.address.postal_code.required' => 'The postal code for the emergency contact person\'s address is required.',
            'emergency_contact.address.postal_code.max' => 'The postal code for the emergency contact person\'s address may not exceed 20 characters.',
        ];
    }
}
