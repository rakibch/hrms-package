<?php

namespace Softzino\EmployeeManagementApi\Rules;

trait AddressRules
{
    /**
     * Get present address validation rules.
     */
    public function presentAddressRules(): array
    {
        return [
            'basic_info.present_address.country' => ['nullable', 'numeric'],
            'basic_info.present_address.city' => ['nullable', 'string', 'max:100', 'min:2'],
            'basic_info.present_address.street' => ['nullable', 'string', 'max:255', 'min:2'],
            'basic_info.present_address.state' => ['nullable', 'string', 'max:100', 'min:2'],
            'basic_info.present_address.postal_code' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Get permanent address validation rules.
     */
    public function permanentAddressRules(): array
    {
        return [
            'basic_info.permanent_address_same_as_present_address' => ['nullable', 'boolean'],
            'basic_info.permanent_address.country' => ['nullable', 'numeric'],
            'basic_info.permanent_address.city' => ['nullable', 'string', 'max:100', 'min:2'],
            'basic_info.permanent_address.street' => ['nullable', 'string', 'max:255'],
            'basic_info.permanent_address.state' => ['nullable', 'string', 'max:100', 'min:2'],
            'basic_info.permanent_address.postal_code' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Get address validation messages.
     */
    public function addressMessages(): array
    {
        return [
            // Present address messages
            'basic_info.present_address.country.numeric' => 'The country for the present address must be a valid number.',
            'basic_info.present_address.city.string' => 'The city for the present address must be a valid string.',
            'basic_info.present_address.city.max' => 'The city for the present address may not be greater than 100 characters.',
            'basic_info.present_address.city.min' => 'The city for the present address must be at least 2 characters.',
            'basic_info.present_address.street.string' => 'The street address for the present address must be a valid string.',
            'basic_info.present_address.street.max' => 'The street address for the present address may not be greater than 255 characters.',
            'basic_info.present_address.street.min' => 'The street address for the present address must be at least 2 characters.',
            'basic_info.present_address.state.string' => 'The state for the present address must be a valid string.',
            'basic_info.present_address.state.max' => 'The state for the present address may not be greater than 100 characters.',
            'basic_info.present_address.state.min' => 'The state for the present address must be at least 2 characters.',
            'basic_info.present_address.postal_code.string' => 'The postal code for the present address must be a valid string.',
            'basic_info.present_address.postal_code.max' => 'The postal code for the present address may not be greater than 20 characters.',

            // Permanent address messages
            'basic_info.permanent_address_same_as_present_address.boolean' => 'The permanent address option must be a boolean value.',
            'basic_info.permanent_address.country.numeric' => 'The country for the permanent address must be a valid number.',
            'basic_info.permanent_address.city.string' => 'The city for the permanent address must be a valid string.',
            'basic_info.permanent_address.city.max' => 'The city for the permanent address may not be greater than 100 characters.',
            'basic_info.permanent_address.city.min' => 'The city for the permanent address must be at least 2 characters.',
            'basic_info.permanent_address.street.string' => 'The street address for the permanent address must be a valid string.',
            'basic_info.permanent_address.street.max' => 'The street address for the permanent address may not be greater than 255 characters.',
            'basic_info.permanent_address.state.string' => 'The state for the permanent address must be a valid string.',
            'basic_info.permanent_address.state.max' => 'The state for the permanent address may not be greater than 100 characters.',
            'basic_info.permanent_address.state.min' => 'The state for the permanent address must be at least 2 characters.',
            'basic_info.permanent_address.postal_code.string' => 'The postal code for the permanent address must be a valid string.',
            'basic_info.permanent_address.postal_code.max' => 'The postal code for the permanent address may not be greater than 20 characters.',
        ];
    }
}
