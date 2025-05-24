<?php

namespace App\Http\Requests\Designation;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Models\Designation;

class UpdateDesignationRequest extends FormRequest
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
        // Get the ID of the designation being updated
        $designation = $this->route('designation');

        return [
            'name' => [
                'required',
                'string',
                'max:50',
                Rule::unique(Designation::class, 'name')
                    ->ignore($designation)
                    ->withoutTrashed(),
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
