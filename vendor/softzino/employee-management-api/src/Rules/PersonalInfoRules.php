<?php

namespace Softzino\EmployeeManagementApi\Rules;

use Illuminate\Validation\Rules\Enum;
use Softzino\EmployeeManagementApi\Enums\BloodGroup;
use Softzino\EmployeeManagementApi\Enums\Gender;
use Softzino\EmployeeManagementApi\Enums\MaritalStatus;
use Softzino\EmployeeManagementApi\Enums\Religion;

trait PersonalInfoRules
{
    // Constants for personal info related validations
    const MAX_NAME_LENGTH = 60;
    const MIN_NAME_LENGTH = 2;
    const MAX_EMAIL_LENGTH = 100;
    const MAX_CONTACT_NUMBER_LENGTH = 13;

    /**
     * Get personal info validation rules.
     */
    public function personalInfoRules(): array
    {
        return [
            'basic_info.first_name' => ['required_if:profile_status,complete', 'nullable', 'string', 'max:' . self::MAX_NAME_LENGTH, 'min:' . self::MIN_NAME_LENGTH],
            'basic_info.last_name' => ['required_if:profile_status,complete', 'nullable', 'string', 'max:' . self::MAX_NAME_LENGTH, 'min:' . self::MIN_NAME_LENGTH],
            'basic_info.dob' => ['required_if:profile_status,complete', 'nullable', 'date', 'before:today'],
            'basic_info.gender' => ['required_if:profile_status,complete', 'nullable', new Enum(Gender::class)],
            'basic_info.marital_status' => ['nullable', new Enum(MaritalStatus::class)],
            'basic_info.religion' => ['nullable', new Enum(Religion::class)],
            'basic_info.blood_group' => ['nullable', new Enum(BloodGroup::class)],
            'basic_info.personal_contact_no' => ['required_if:profile_status,complete', 'nullable', 'string','min:13', 'regex:/^\+?[0-9]{10,' . self::MAX_CONTACT_NUMBER_LENGTH . '}$/'],
            'basic_info.personal_email' => ['required_if:profile_status,complete', 'nullable', 'email', 'max:' . self::MAX_EMAIL_LENGTH],
            'basic_info.profile_image' => ['nullable', 'max:2048'],
        ];
    }

    /**
     * Get personal info validation messages.
     */
    public function personalInfoMessages(): array
    {
        return [
            'basic_info.first_name.required_if' => 'The first name is required.',
            'basic_info.first_name.max' => 'The first name may not be greater than ' . self::MAX_NAME_LENGTH . ' characters.',
            'basic_info.first_name.min' => 'The first name must be at least ' . self::MIN_NAME_LENGTH . ' characters.',

            'basic_info.last_name.required_if' => 'The last name is required.',
            'basic_info.last_name.max' => 'The last name may not be greater than ' . self::MAX_NAME_LENGTH . ' characters.',
            'basic_info.last_name.min' => 'The last name must be at least ' . self::MIN_NAME_LENGTH . ' characters.',

            'basic_info.dob.date' => 'The date of birth must be a valid date.',
            'basic_info.dob.before' => 'The date of birth must be before today.',
            'basic_info.dob.required_if' => 'The date of birth is required.',

            'basic_info.gender.required_if' => 'The gender is required.',

            'basic_info.personal_contact_no.required_if' => 'The personal contact number is required',
            'basic_info.personal_contact_no.regex' => 'The contact number must be a valid phone number.',
            'basic_info.personal_contact_no.min' => 'The contact number must be a valid phone number.',
            'basic_info.personal_email.required_if' => 'The personal email is required.',
        ];
    }
}
