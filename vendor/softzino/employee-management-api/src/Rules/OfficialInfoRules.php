<?php

namespace Softzino\EmployeeManagementApi\Rules;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Models\Designation;
use Softzino\EmployeeManagementApi\Enums\EmploymentType;

trait OfficialInfoRules
{
    // Constants for official info related validations
    protected const MAX_OFFICIAL_EMAIL_LENGTH = 20;
    protected const OFFICIAL_CONTACT_REGEX = '/^\+?[0-9]{13}$/';

    /**
     * Get official info validation rules.
     */
    public function officialInfoRules(): array
    {
        return [
            'job_details.job_type' => ['nullable', 'string'],

            'job_details.department_id' => [
                'required_if:profile_status,complete',
                'nullable',
                'integer',
                Rule::exists(Department::class, 'id')->withoutTrashed(),
            ],

            'job_details.designation_id' => [
                'required_if:profile_status,complete',
                'nullable',
                'integer',
                Rule::exists(Designation::class, 'id')->withoutTrashed(),
            ],

            'job_details.employment_type' => [
                'required_if:profile_status,complete',
                'nullable',
                'string',
                new Enum(EmploymentType::class),
            ],

            'job_details.official_contact_no' => [
                'nullable',
                'string',
                'regex:' . self::OFFICIAL_CONTACT_REGEX,
            ],

            'job_details.official_email' => [
                'nullable',
                'email',
                'max:' . self::MAX_OFFICIAL_EMAIL_LENGTH,
                'unique:users,email',
            ],
        ];
    }

    /**
     * Get official info validation messages.
     */
    public function officialInfoMessages(): array
    {
        return [
            'job_details.department_id.required_if' => 'The department is required.',
            'job_details.department_id.exists' => 'The selected department does not exist.',

            'job_details.designation_id.required_if' => 'The designation is required.',
            'job_details.designation_id.exists' => 'The selected designation does not exist.',

            'job_details.employment_type.required_if' => 'The employment type is required.',

            'job_details.official_contact_no.regex' => 'The official contact number must be a valid format.',

            'job_details.official_email.email' => 'The official email must be a valid email address.',
            'job_details.official_email.max' => 'The official email must not exceed ' . self::MAX_OFFICIAL_EMAIL_LENGTH . ' characters.',
            'job_details.official_email.unique' => 'The official email is already in use.',
        ];
    }
}
