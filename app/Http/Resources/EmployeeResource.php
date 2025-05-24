<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->fullName,
            'profile_image'     => $this->profile_image,
            'employee_no'       => $this->employee_no,
            'department_name'   => $this->department->name ?? null,
            'designation_name'  => $this->designation->name ?? null,
            'join_date'         => $this->join_date,
            'employment_status' => ucfirst($this->employment_status), // Example: 'Active', 'Terminated'
            'profile_status'    => ucfirst($this->profile_completion_status), // Changed field name
            'created_by'        => optional($this->creator)->first_name . ' ' . optional($this->creator)->last_name,
        ];
    }
}
