<?php

namespace Softzino\EmployeeManagementApi\Http\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $head = [
            'id' => $this->whenLoaded('head', optional($this->head)->id),
            'name' => $this->whenLoaded('head', optional($this->head)->full_name),
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'designations_count' => $this->designations_count ?? 0,
            'employees_count' => $this->employees_count ?? 0,
            'status' => $this->is_active ? 'Active' : 'Inactive',
            'department_head' => $head,
            'created_by' => $this->created_by_name,
            'updated_at' => $this->updated_at ?? null,
        ];
    }
}
