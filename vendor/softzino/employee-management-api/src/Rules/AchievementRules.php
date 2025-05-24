<?php

namespace Softzino\EmployeeManagementApi\Rules;

trait AchievementRules
{
    // Constants for achievement-related validations
    const MAX_INSTITUTION_NAME_LENGTH = 255;
    const MAX_DEGREE_LENGTH = 255;
    const MAX_FIELD_OF_STUDY_LENGTH = 255;
    const MAX_COURSE_NAME_LENGTH = 255;
    const MAX_ORGANIZATION_LENGTH = 255;
    const MAX_URL_LENGTH = 2048;

    /**
     * Get validation rules for achievements.
     */
    public function achievementRules(): array
    {
        return [
            // Education validation
            'achievements.education' => ['array', 'nullable'],
            'achievements.education.*.institution_name' => ['nullable', 'string', 'max:' . self::MAX_INSTITUTION_NAME_LENGTH],
            'achievements.education.*.degree' => ['nullable', 'string', 'max:' . self::MAX_DEGREE_LENGTH],
            'achievements.education.*.field_of_study' => ['nullable', 'string', 'max:' . self::MAX_FIELD_OF_STUDY_LENGTH],
            'achievements.education.*.start_date' => ['nullable', 'date'],
            'achievements.education.*.end_date' => ['nullable', 'date', 'after_or_equal:achievements.education.*.start_date'],
            'achievements.education.*.is_running' => ['nullable', 'boolean'],

            // Work Experience validation
            'achievements.work_experience' => ['array', 'nullable'],
            'achievements.work_experience.*.institution_name' => ['nullable', 'string', 'max:' . self::MAX_INSTITUTION_NAME_LENGTH],
            'achievements.work_experience.*.designation' => ['nullable', 'string'],
            'achievements.work_experience.*.start_date' => ['nullable', 'date'],
            'achievements.work_experience.*.end_date' => ['nullable', 'date', 'after_or_equal:achievements.work_experience.*.start_date'],
            'achievements.work_experience.*.is_running' => ['nullable', 'boolean'],

            // Certification validation
            'achievements.certifications' => ['array', 'nullable'],
            'achievements.certifications.*.course_name' => ['nullable', 'string', 'max:' . self::MAX_COURSE_NAME_LENGTH],
            'achievements.certifications.*.issuing_organization' => ['nullable', 'string', 'max:' . self::MAX_ORGANIZATION_LENGTH],
            'achievements.certifications.*.start_date' => ['nullable', 'date'],
            'achievements.certifications.*.completion_date' => ['nullable', 'date', 'after_or_equal:achievements.certifications.*.start_date'],
            'achievements.certifications.*.certificate_files' => ['nullable', 'array'],
            'achievements.certifications.*.certificate_files.*' => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:10000'],
        ];
    }

    /**
     * Get validation messages for achievements fields.
     */
    /**
     * Get validation messages for achievements fields.
     */
    public function achievementMessages(): array
    {
        return [
            // General Messages
            'achievements.education.array' => 'The education field must be an array.',
            'achievements.education.nullable' => 'The education field is optional.',
            'achievements.work_experience.array' => 'The work experience field must be an array.',
            'achievements.work_experience.nullable' => 'The work experience field is optional.',
            'achievements.certifications.array' => 'The certifications field must be an array.',
            'achievements.certifications.nullable' => 'The certifications field is optional.',

            // Education Messages
            'achievements.education.*.institution_name.string' => 'The institution name must be a valid string.',
            'achievements.education.*.institution_name.max' => 'The institution name may not exceed ' . self::MAX_INSTITUTION_NAME_LENGTH . ' characters.',
            'achievements.education.*.degree.string' => 'The degree must be a valid string.',
            'achievements.education.*.degree.max' => 'The degree may not exceed ' . self::MAX_DEGREE_LENGTH . ' characters.',
            'achievements.education.*.field_of_study.string' => 'The field of study must be a valid string.',
            'achievements.education.*.field_of_study.max' => 'The field of study may not exceed ' . self::MAX_FIELD_OF_STUDY_LENGTH . ' characters.',
            'achievements.education.*.start_date.date' => 'The start date must be a valid date.',
            'achievements.education.*.end_date.date' => 'The end date must be a valid date.',
            'achievements.education.*.end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'achievements.education.*.is_running.boolean' => 'The is_running field must be true or false.',

            // Work Experience Messages
            'achievements.work_experience.*.institution_name.string' => 'The institution name must be a valid string.',
            'achievements.work_experience.*.institution_name.max' => 'The institution name may not exceed ' . self::MAX_INSTITUTION_NAME_LENGTH . ' characters.',
            'achievements.work_experience.*.designation.string' => 'The designation must be a valid string.',
            'achievements.work_experience.*.start_date.date' => 'The start date must be a valid date.',
            'achievements.work_experience.*.end_date.date' => 'The end date must be a valid date.',
            'achievements.work_experience.*.end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            'achievements.work_experience.*.is_running.boolean' => 'The is_running field must be true or false.',

            // Certifications Messages
            'achievements.certifications.*.course_name.string' => 'The course name must be a valid string.',
            'achievements.certifications.*.course_name.max' => 'The course name may not exceed ' . self::MAX_COURSE_NAME_LENGTH . ' characters.',
            'achievements.certifications.*.issuing_organization.string' => 'The issuing organization must be a valid string.',
            'achievements.certifications.*.issuing_organization.max' => 'The issuing organization may not exceed ' . self::MAX_ORGANIZATION_LENGTH . ' characters.',
            'achievements.certifications.*.start_date.date' => 'The start date must be a valid date.',
            'achievements.certifications.*.completion_date.date' => 'The completion date must be a valid date.',
            'achievements.certifications.*.completion_date.after_or_equal' => 'The completion date must be after or equal to the start date.',
            'achievements.certifications.*.certificate_url.url' => 'The certificate URL must be a valid URL.',
            'achievements.certifications.*.certificate_url.max' => 'The certificate URL may not exceed ' . self::MAX_URL_LENGTH . ' characters.',

            // Certification Files Messages
            'achievements.certifications.*.certificate_files.array' => 'The certificate files must be an array.',
            'achievements.certifications.*.certificate_files.*.file' => 'Each certificate file must be a valid file.',
            'achievements.certifications.*.certificate_files.*.mimes' => 'Each certificate file must be in PDF, JPG, JPEG, or PNG format.',
            'achievements.certifications.*.certificate_files.*.max' => 'Each certificate file must not exceed 10MB in size.',
        ];
    }
}
