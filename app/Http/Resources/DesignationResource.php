<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $reporter = [
            'id' => $this->reporter->id ?? null,
            'name' => $this->reporter->fullname ?? null,
        ];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'department' => [
                'id' => $this->department->id,
                'name' => $this->department->name,
            ],
            'total_employees' => $this->employees_count,
            'last_modified_at' => $this->updated_at ?? null,
            'supervisor' => $this->reporter
                ? $reporter
                : null,
            'created_by' => $this->creator?->fullname ?? null,
            'status' => $this->is_active ? 'Active' : 'Inactive',
        ];
    }
}
