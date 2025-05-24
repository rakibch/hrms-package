<?php

namespace Softzino\EmployeeManagementApi\Rules;

use Illuminate\Validation\Rule;
use Softzino\EmployeeManagement\Models\EmployeeContact;

trait UpdateContactsRule
{
    // Constants for contact-related validations
    const MAX_TITLE_LENGTH = 100;
    const MAX_CONTACT_NO_LENGTH = 15;
    const MAX_CITY_LENGTH = 100;
    const MAX_STATE_LENGTH = 100;
    const MAX_STREET_LENGTH = 200;
    const MAX_POSTAL_CODE_LENGTH = 10;
    const MAX_COUNTRY_LENGTH = 100;

    /**
     * Get validation rules for contact information.
     */
    public function contactRules(): array
    {
        return [
            'basic_info.contacts' => ['array', 'nullable'],
            'basic_info.contacts.*.id' => [
                'sometimes',
                'integer',
                Rule::exists(EmployeeContact::class, 'id'),
            ],
            'basic_info.contacts.*.relationship' => ['required_if:profile_status,complete', 'string', 'max:' . self::MAX_TITLE_LENGTH],
            'basic_info.contacts.*.name' => ['required_if:profile_status,complete', 'string', 'max:' . self::MAX_TITLE_LENGTH],
            'basic_info.contacts.*.contact_no' => [
                'required_if:profile_status,complete',
                'string',
                'max:' . self::MAX_CONTACT_NO_LENGTH,
                'regex:/^\+?[0-9\-]+$/'
            ],
            'basic_info.contacts.*.address' => ['array', 'nullable'],
            'basic_info.contacts.*.address.street' => ['nullable', 'string', 'max:' . self::MAX_STREET_LENGTH],
            'basic_info.contacts.*.address.city' => ['nullable', 'string', 'max:' . self::MAX_CITY_LENGTH],
            'basic_info.contacts.*.address.state' => ['nullable', 'string', 'max:' . self::MAX_STATE_LENGTH],
            'basic_info.contacts.*.address.postal_code' => ['nullable', 'string', 'max:' . self::MAX_POSTAL_CODE_LENGTH],
            'basic_info.contacts.*.address.country' => ['nullable', 'numeric', 'max:' . self::MAX_COUNTRY_LENGTH],
        ];
    }

    /**
     * Get validation messages for contact fields.
     */
    public function contactMessages(): array
    {
        return [
            'basic_info.contacts.*.relationship.required_if' => 'The relationship field is required when profile status is complete.',
            'basic_info.contacts.*.name.required_if' => 'The contact person name is required when profile status is complete.',
            'basic_info.contacts.*.name.max' => 'The contact person name may not be greater than ' . self::MAX_TITLE_LENGTH . ' characters.',
            'basic_info.contacts.*.contact_no.required_if' => 'The contact number is required when profile status is complete.',
            'basic_info.contacts.*.contact_no.max' => 'The contact number may not be greater than ' . self::MAX_CONTACT_NO_LENGTH . ' characters.',
            'basic_info.contacts.*.contact_no.regex' => 'The contact number format is invalid. It should contain only numbers, dashes, and optionally start with a "+".',
            'basic_info.contacts.*.address.street.max' => 'The street address may not be greater than ' . self::MAX_STREET_LENGTH . ' characters.',
            'basic_info.contacts.*.address.city.max' => 'The city name may not be greater than ' . self::MAX_CITY_LENGTH . ' characters.',
            'basic_info.contacts.*.address.state.max' => 'The state/province name may not be greater than ' . self::MAX_STATE_LENGTH . ' characters.',
            'basic_info.contacts.*.address.postal_code.max' => 'The postal code may not be greater than ' . self::MAX_POSTAL_CODE_LENGTH . ' characters.',
            'basic_info.contacts.*.address.country.max' => 'The country name may not be greater than ' . self::MAX_COUNTRY_LENGTH . ' characters.',
        ];
    }
}
