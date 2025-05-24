<?php

namespace Softzino\EmployeeManagementApi\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Models\Employee;

class CreateDepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $departmentId = $this->route('department');

        return [
            'name' => [
                'required',
                'string',
                'max:60',
                'min:2',
                Rule::unique(Department::class, 'name')
                    ->ignore($departmentId)
                    ->withoutTrashed(),
            ],
            'head_id' => [
                'nullable',
                'integer',
                Rule::exists(Employee::class, 'id'),
            ],
            'is_active' => 'nullable|boolean',
        ];
    }
}
