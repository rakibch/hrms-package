<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;
use Softzino\EmployeeManagement\Models\Certification;
use Softzino\EmployeeManagement\Models\EducationalInformation;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagement\Models\EmployeeContact;
use Softzino\EmployeeManagement\Models\EmployeeDocument;
use Softzino\EmployeeManagement\Models\ProfessionalExperience;

class EmployeeRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function createEmployee(array $validated): void
    {
//        dd($validated);
        DB::transaction(function () use ($validated) {
            $user = $this->createUser($validated);
            $validated['basic_info']['profile_image'] = $this->handleProfileImageUpload($validated, $user->user_name);
            $employee = $this->storeEmployee($validated, $user->id);
            $this->storeAddresses($validated, $employee);
            $this->storeContacts($validated, $employee);
            $this->storeDocuments($validated, $employee, $user->user_name);
            $this->storeAchievements($validated, $employee);
        });
    }

    private function createUser(array $validated): User
    {
        return User::create([
            'user_name'  => $validated['basic_info']['user_name'],
            'first_name' => $validated['basic_info']['first_name'] ?? '',
            'last_name'  => $validated['basic_info']['last_name'] ?? '',
            'email'      => $validated['basic_info']['personal_email'] ?? null,
            'password'   => Hash::make('password'),
            'is_active'  => $validated['profile_status'] !== 'draft',
        ]);
    }

    private function storeEmployee(array $validated, int $userId): Employee
    {
        // Remove user-related properties before storing employee details
        $employeeBasicData = $validated['basic_info'];
        unset(
            $employeeBasicData['user_name'],
            $employeeBasicData['first_name'],
            $employeeBasicData['last_name'],
            $employeeBasicData['personal_email']
        );

        // Generate employee number
        $employeeBasicData['employee_no'] = $this->generateEmployeeNumber($employeeBasicData);

        $employeeOfficialData = $validated['job_details'];

        return EmployeeManagement::create(array_merge($employeeBasicData, $employeeOfficialData, [
            'user_id' => $userId,
            'profile_completion_status' => $validated['profile_status'],
            'employment_status' => $this->getEmploymentStatus($validated['profile_status']),
            'created_by' => auth()->id(),
        ]));
    }

    private function generateEmployeeNumber(array $basicInfo): string
    {
        return $basicInfo['identity_type'] === 'automatic'
            ? strtoupper(uniqid('EMP-'))
            : $basicInfo['employee_no'];
    }

    private function getEmploymentStatus(string $profileStatus): string
    {
        return $profileStatus === 'draft' ? 'inactive' : (config('employee-management.defaults.employee_active', false) ? 'active' : 'inactive');
    }

    private function storeAddresses(array $validated, $employee): void
    {
        $this->storeAddress($employee, 'present', $validated['basic_info']['present_address']);

        if (!$validated['basic_info']['permanent_address_same_as_present_address']) {
            $this->storeAddress($employee, 'permanent', $validated['basic_info']['permanent_address']);
        }

        if(!$validated['work_location']['is_same_as_present_address']) {
            $this->storeAddress($employee, 'worklocation', $validated['work_location']);
        }
    }

    private function storeAddress($employee, string $type, ?array $address): void
    {
        if (!$address || empty(array_filter($address))) {
            return;
        }

        $employee->addresses()->create([
            'type'          => $type,
            'country'       => $address['country'] ?? null,
            'city'          => $address['city'] ?? null,
            'street'        => $address['street'] ?? $address['streetAddress'] ?? null,
            'state'         => $address['state'] ?? $address['stateOrProvince'] ?? null,
            'postal_code'   => $address['postal_code'] ?? $address['postcode'] ?? null,
            'lat'           => $address['lat'] ?? null,
            'long'          => $address['long'] ?? null,
            'created_by'    => auth()->id(),
        ]);
    }

    private function storeContacts(array $validated, $employee): void
    {
        $contacts = $validated['basic_info']['contacts'] ?? [];

        foreach ($contacts as $contact) {
            EmployeeContact::create([
                'employee_id'  => $employee->id,
                'name'         => $contact['name'],
                'relationship' => $contact['relationship'],
                'contact_no'   => $contact['contact_no'],
                'street'       => $contact['address']['street'] ?? null,
                'city'         => $contact['address']['city'] ?? null,
                'state'        => $contact['address']['state'] ?? null,
                'postal_code'  => $contact['address']['postal_code'] ?? null,
                'country'      => $contact['address']['country'] ?? null,
                'created_by'   => auth()->id(),
            ]);
        }
    }

    private function storeDocuments(array $validated, $employee, string $userName): void
    {
        if (!empty($validated['basic_info']['documents'])) {
            foreach ($validated['basic_info']['documents'] as $document) {
                foreach ($document['files'] ?? [] as $file) {
                    if ($file instanceof UploadedFile) {
                        $this->storeEmployeeDocument($employee->id, $userName, $file, $document['type'], $document['expiryDate'] ?? null);
                    }
                }
            }
        }
    }

    private function storeEmployeeDocument(int $employeeId, string $userName, UploadedFile $file, string $documentType, ?string $expiryDate): void
    {
        $filePath = $this->storeFile("employee/{$userName}/documents", $file);

        EmployeeDocument::create([
            'employee_id'   => $employeeId,
            'document_type' => $documentType,
            'document_path' => $filePath,
            'expiry_date'   => $expiryDate,
            'created_by'    => auth()->id(),
        ]);
    }

    private function handleProfileImageUpload(array $validated, string $userName): ?string
    {
        $profileImage = request()->file('basic_info.profile_image');

        return $profileImage instanceof UploadedFile
            ? $this->storeFile("employee/{$userName}/images", $profileImage)
            : null;
    }

    private function storeFile(string $directory, UploadedFile $file): string
    {
        $fileName = time() . '-' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = "{$directory}/{$fileName}";

        Storage::disk('s3')->put($filePath, file_get_contents($file));

        return Storage::disk('s3')->url($filePath);
    }

    private function storeAchievements(array $validated, $employee): void
    {
        // Store Education Information
        $educations = $validated['achievements']['education'] ?? [];
        foreach ($educations as $education) {
            EducationalInformation::create([
                'employee_id'         => $employee->id,
                'institution_name'    => $education['institution_name'] ?? null,
                'degree'              => $education['degree'] ?? null,
                'field_of_study'      => $education['field_of_study'] ?? null,
                'start_date'          => $education['start_date'] ?? null,
                'end_date'            => $education['end_date'] ?? null,
                'grade'               => $education['grade'] ?? null,
                'certificate_file_path' => $education['certificate_file_path'] ?? null,
                'is_running'          => $education['is_running'] ?? false,
                'created_by'          => $employee->created_by ?? null,
                'updated_by'          => $employee->updated_by ?? null,
            ]);
        }

        // Store Work Experience Information
        $workExperiences = $validated['achievements']['work_experience'] ?? [];
//        dd($workExperiences);
        foreach ($workExperiences as $workExperience) {
            ProfessionalExperience::create([
                'employee_id'         => $employee->id,
                'institution_name'    => $workExperience['institution_name'] ?? null,
                'designation'         => $workExperience['designation'] ?? null,
                'start_date'          => $workExperience['start_date'] ?? null,
                'end_date'            => $workExperience['end_date'] ?? null,
                'is_running'          => $workExperience['is_running'] ?? false,
                'created_by'          => $employee->created_by ?? null,
                'updated_by'          => $employee->updated_by ?? null,
            ]);
        }

        // Store Certification Information
        $certifications = $validated['achievements']['certifications'] ?? [];
        foreach ($certifications as $certification) {
            $certificateUrls = [];

            if (isset($certification['certificate_files']) && is_array($certification['certificate_files'])) {
                foreach ($certification['certificate_files'] as $file) {
                    if ($file instanceof UploadedFile) {
                        $filePath = $this->storeFile("employee/{$employee->id}/certifications", $file);
                        $certificateUrls[] = $filePath;
                    }
                }
            }

            Certification::create([
                'employee_id'         => $employee->id,
                'course_name'         => $certification['course_name'] ?? null,
                'issuing_organization'=> $certification['issuing_organization'] ?? null,
                'start_date'          => $certification['start_date'] ?? null,
                'completion_date'     => $certification['completion_date'] ?? null,
                'certificate_urls'    => !empty($certificateUrls) ? json_encode($certificateUrls) : null, // Save as JSON
                'created_by'          => $employee->created_by ?? null,
                'updated_by'          => $employee->updated_by ?? null,
            ]);
        }
    }
}
