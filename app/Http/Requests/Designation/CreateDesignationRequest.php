<?php

namespace App\Http\Requests\Designation;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Models\Designation;

class CreateDesignationRequest extends FormRequest
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
        return [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique(Designation::class, 'name')->withoutTrashed(),
            ],
            'department_id' => [
                'required',
                'integer',
                Rule::exists(Department::class, 'id')->withoutTrashed(),
            ],
            'reporter_id' => [
                'nullable',
                'integer',
                Rule::exists(User::class, 'id'),
            ],
        ];
    }
}
