<?php

namespace Softzino\EmployeeManagementApi\Rules;

trait WorkLocationRules
{
    // Constants for work location related validations
    const MAX_WORK_LOCATION_CITY_LENGTH = 100;
    const MAX_WORK_LOCATION_STREET_LENGTH = 255;
    const MAX_WORK_LOCATION_STATE_LENGTH = 100;
    const MAX_WORK_LOCATION_POSTAL_CODE_LENGTH = 20;

    /**
     * Get work location validation rules.
     */
    public function workLocationRules(): array
    {
        return [
            'work_location.is_same_as_present_address' => ['nullable', 'boolean'],
            'work_location.country' => ['nullable', 'integer'],
            'work_location.city' => ['nullable', 'string', 'max:' . self::MAX_WORK_LOCATION_CITY_LENGTH],
            'work_location.street' => ['nullable', 'string', 'max:' . self::MAX_WORK_LOCATION_STREET_LENGTH],
            'work_location.state' => ['nullable', 'string', 'max:' . self::MAX_WORK_LOCATION_STATE_LENGTH],
            'work_location.postal_code' => ['nullable', 'string', 'max:' . self::MAX_WORK_LOCATION_POSTAL_CODE_LENGTH],
            'work_location.streetAddress' => ['nullable', 'string', 'max:' . self::MAX_WORK_LOCATION_STREET_LENGTH],
            'work_location.postcode' => ['nullable', 'string', 'max:' . self::MAX_WORK_LOCATION_POSTAL_CODE_LENGTH],
            'work_location.stateOrProvince' => ['nullable', 'string', 'max:' . self::MAX_WORK_LOCATION_STATE_LENGTH],
            'work_location.lat' => ['nullable', 'string', 'between:-90,90'],
            'work_location.lng' => ['nullable', 'string', 'between:-180,180'],
        ];
    }

    /**
     * Get work location validation messages.
     */
    public function workLocationMessages(): array
    {
        return [
            'work_location.country.exists' => 'The selected country does not exist.',

            'work_location.city.max' => 'The city name must not exceed ' . self::MAX_WORK_LOCATION_CITY_LENGTH . ' characters.',
            'work_location.street.max' => 'The street name must not exceed ' . self::MAX_WORK_LOCATION_STREET_LENGTH . ' characters.',
            'work_location.state.max' => 'The state name must not exceed ' . self::MAX_WORK_LOCATION_STATE_LENGTH . ' characters.',
            'work_location.postal_code.max' => 'The postal code must not exceed ' . self::MAX_WORK_LOCATION_POSTAL_CODE_LENGTH . ' characters.',
            'work_location.streetAddress.max' => 'The street address must not exceed ' . self::MAX_WORK_LOCATION_STREET_LENGTH . ' characters.',
            'work_location.postcode.max' => 'The postcode must not exceed ' . self::MAX_WORK_LOCATION_POSTAL_CODE_LENGTH . ' characters.',
            'work_location.stateOrProvince.max' => 'The state or province name must not exceed ' . self::MAX_WORK_LOCATION_STATE_LENGTH . ' characters.',

            'work_location.lat.between' => 'The latitude must be between -90 and 90.',
            'work_location.lng.between' => 'The longitude must be between -180 and 180.',
        ];
    }
}
