<?php

namespace Softzino\EmployeeManagementApi\Http\Requests\Employee;



use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagementApi\Enums\IdentityType;
use Softzino\EmployeeManagementApi\Rules\AchievementRulesUpdate;
use Softzino\EmployeeManagementApi\Rules\PersonalInfoRules;
use Softzino\EmployeeManagementApi\Rules\AddressRules;
use Softzino\EmployeeManagementApi\Rules\EmergencyContactRules;
use Softzino\EmployeeManagementApi\Rules\OfficialInfoRules;
use Softzino\EmployeeManagementApi\Rules\AchievementRules;
use Softzino\EmployeeManagementApi\Rules\UpdateContactsRule;
use Softzino\EmployeeManagementApi\Rules\WorkLocationRules;
use Illuminate\Contracts\Validation\Validator;

class UpdateRequest extends FormRequest
{
    use AddressRules, PersonalInfoRules, EmergencyContactRules, OfficialInfoRules, UpdateContactsRule, AchievementRulesUpdate, WorkLocationRules;

    // Constants for profile status
    const PROFILE_STATUS_DRAFT = 'draft';
    const PROFILE_STATUS_COMPLETE = 'complete';

    /**
     * Get the employee ID from the route or return null.
     */
    private function getEmployeeId()
    {
        return $this->route('employee');
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $employee = $this->getEmployeeId();

        return array_merge(
            $this->identityRules($employee),
            $this->personalInfoRules(),
            $this->presentAddressRules(),
            $this->permanentAddressRules(),
            $this->contactRules(),
            [
                'basic_info.documents' => ['nullable', 'array'],
            ],
            $this->officialInfoRules(),
            $this->achievementRulesUpdate(),
            $this->workLocationRules(),
        );
    }

    /**
     * Customize the error messages for validation rules.
     */
    public function messages(): array
    {
        return array_merge(
            $this->identityMessages(),
            $this->personalInfoMessages(),
            $this->addressMessages(),
            $this->contactMessages(),
            $this->officialInfoMessages(),
            $this->achievementMessages(),
            $this->workLocationMessages(),
        );
    }

    /**
     * Validation rules for identity fields.
     */
    private function identityRules($employee): array
    {
        return [
            'profile_status' => ['required', 'in:' . self::PROFILE_STATUS_DRAFT . ',' . self::PROFILE_STATUS_COMPLETE],

            'basic_info.identity_type' => ['required', new Enum(IdentityType::class)],
            'basic_info.employee_no' => [
                'nullable',
                'required_if:basic_info.identity_type,manual',
                'string',
                'regex:/^[A-Z0-9-]{6,20}$/',
                Rule::unique(Employee::class, 'employee_no')->ignore($employee),
            ],
            'basic_info.user_name' => [
                'required',
                'string',
                'max:60',
                // Todo: Add unique rule for user_name after authentication is implemented
            ],
            'basic_info.join_date' => ['required', 'date'],
        ];
    }

    /**
     * Custom error messages for identity validation rules.
     */
    private function identityMessages(): array
    {
        return [
            'basic_info.identity_type.required' => 'Please select an identity type.',

            'basic_info.employee_no.required_if' => 'The employee number is required.',
            'basic_info.employee_no.regex' => 'The employee number must be 6-12 uppercase letters or digits.',
            'basic_info.employee_no.unique' => 'The employee number is already in use.',

            'basic_info.user_name.required' => 'The user name is required.',
            'basic_info.user_name.string' => 'The user name must be a string.',
            'basic_info.user_name.max' => 'The user name must not be greater than 60 characters.',
            'basic_info.user_name.unique' => 'The user name is already in use.',

            'basic_info.join_date.required' => 'The join date is required.',
            'basic_info.join_date.date' => 'The join date must be a valid date.',
        ];
    }

//    protected function failedValidation(Validator $validator)
//    {
//       dd($validator->errors());
//    }
}
