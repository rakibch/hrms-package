<?php

namespace Softzino\EmployeeManagementApi\Http\Requests\Designation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Softzino\EmployeeManagement\Models\Department;
use Softzino\EmployeeManagement\Models\Designation;

class UpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $designationId = $this->route('designation');

        return [
            'name' => ['required', 'string', 'max:60'],
            'reporting_to_designation_id' => [
                'nullable',
                'integer',
                Rule::exists(Designation::class, 'id')->withoutTrashed()
                    ->where(function ($query) use ($designationId) {
                        return $query->where('id', '!=', $designationId);
                    })
            ],
            'departments' => ['nullable', 'array'],
            'departments.*' => [
                'integer',
                Rule::exists(Department::class, 'id')->withoutTrashed()
            ],
        ];
    }
}
