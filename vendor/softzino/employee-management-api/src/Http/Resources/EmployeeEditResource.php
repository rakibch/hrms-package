<?php

namespace Softzino\EmployeeManagementApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeEditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // Assume addresses relationship exists and has `type` field
        $present   = $this->addresses->firstWhere('type', 'present');
        $permanent = $this->addresses->firstWhere('type', 'permanent');

        return [
            'id'               => $this->id,
            'profile_status'   => $this->profile_completion_status,

            'basic_info' => [
                'identity_type'    => $this->identity_type,
                'employee_no'      => $this->employee_no,
                'user_name'        => $this->full_name,
                'join_date'        => $this->join_date,
                'profile_image'    => $this->profile_image,

                'first_name'       => $this->first_name,
                'last_name'        => $this->last_name,
                'dob'              => $this->dob,
                'gender'           => $this->gender,
                'marital_status'   => $this->marital_status,
                'religion'         => $this->religion,
                'blood_group'      => $this->blood_group,

                'personal_contact_no' => $this->personal_contact_no,
                'personal_email'      => $this->personal_email,

                'present_address' => [
                    'country'     => $present?->country     ?? '',
                    'city'        => $present?->city        ?? '',
                    'street'      => $present?->street      ?? '',
                    'state'       => $present?->state       ?? '',
                    'postal_code' => $present?->postal_code ?? '',
                ],

                'permanent_address_same_as_present_address'
                => $this->permanent_address_same_as_present_address,

                'permanent_address' => [
                    'country'     => $permanent?->country     ?? '',
                    'city'        => $permanent?->city        ?? '',
                    'street'      => $permanent?->street      ?? '',
                    'state'       => $permanent?->state       ?? '',
                    'postal_code' => $permanent?->postal_code ?? '',
                ],

                'contacts'  => $this->contacts->map(function ($contact) {
                    return [
                        "id" => $contact->id,
                        "name" => $contact->name,
                        "relationship" => $contact->relationship,
                        "contact_no" => $contact->contact_no,
                        "street" => $contact->street,
                        "city" => $contact->city,
                        "state" => $contact->state,
                        "postal_code" => $contact->postal_code,
                        "country" => $contact->country,
                        "created_by" => $contact->created_by
                    ];
                })->toArray(),

                'documents' => $this->employeeDocuments->map(function ($doc) {
                    return [
                        'id' => $doc->id,
                        'files'   => [$doc->document_path],
                        'type' => $doc->document_type ?? null,
                        'expiry_date' => $doc->expiry_date ?? null
                    ];
                })->toArray(),
            ],

            'job_details' => [
                'job_type'            => $this->job_type,
                'department_id'       => $this->department_id,
                'designation_id'      => $this->designation_id,
                'employment_type'     => $this->employment_type,
                'official_contact_no' => $this->official_contact_no,
                'official_email'      => $this->official_email,
            ],
            'achievements' => [
                'education'        => $this->educationalInformations,
                'work_experience'  => $this->professionalExperiences,
                'certifications'   => $this->certifications,
            ],

            'work_location' => [
                'is_same_as_present_address'
                => $this->work_address_same_as_present_address,
                // Assumes work address defined same as present
                'country'     => $present?->country     ?? '',
                'city'        => $present?->city        ?? '',
                'street'      => $present?->street      ?? '',
                'state'       => $present?->state       ?? '',
                'postal_code' => $present?->postal_code ?? '',
            ],
        ];
    }
}
