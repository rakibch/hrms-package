<?php

namespace Softzino\EmployeeManagementApi\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'departments' => $this->whenLoaded('departments', function () {
                return $this->departments->map(fn ($department) => [
                    'id' => $department->id,
                    'name' => $department->name,
                ])->toArray();
            }),
            'total_employees' => $this->employees_count ?? 0,
            'last_modified_at' => $this->updated_at?->toDateTimeString(),
            'supervisor' => $this->whenLoaded('reportingTo', function () {
                return [
                    'id' => $this->reportingTo->id,
                    'name' => $this->reportingTo->name,
                ];
            }),
            'created_by' => $this->created_by_name,
            'status' => $this->status_label,
        ];
    }
}
