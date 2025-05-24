<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Softzino\EmployeeManagement\Contracts\Repositories\CertificationRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeAddressRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeContactsRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeDocumentRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeEducationRepositoryInterface;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeProfessionalExperienceRepositoryInterface;
use Softzino\EmployeeManagement\Facades\EmployeeManagement;
use Softzino\EmployeeManagement\Models\Certification;
use Softzino\EmployeeManagement\Models\EducationalInformation;
use Softzino\EmployeeManagement\Models\Employee;
use Softzino\EmployeeManagement\Models\EmployeeDocument;
use Softzino\EmployeeManagement\Models\ProfessionalExperience;

class EmployeeRepository extends BaseRepository
{
    protected EmployeeAddressRepositoryInterface $addressRepository;

    protected EmployeeContactsRepositoryInterface $contactRepository;

    protected EmployeeDocumentRepositoryInterface $documentRepository;

    protected EmployeeEducationRepositoryInterface $educationRepository;

    protected CertificationRepositoryInterface $certificationRepository;

    protected EmployeeProfessionalExperienceRepositoryInterface $experienceRepository;

    public function __construct(
        Employee $model,
        EmployeeAddressRepositoryInterface $addressRepository,
        EmployeeContactsRepositoryInterface $contactRepository,
        EmployeeDocumentRepositoryInterface $documentRepository,
        EmployeeEducationRepositoryInterface $educationRepository,
        CertificationRepositoryInterface $certificationRepository,
        EmployeeProfessionalExperienceRepositoryInterface $experienceRepository
    ) {
        $this->model = $model;
        $this->addressRepository = $addressRepository;
        $this->contactRepository = $contactRepository;
        $this->documentRepository = $documentRepository;
        $this->educationRepository = $educationRepository;
        $this->certificationRepository = $certificationRepository;
        $this->experienceRepository = $experienceRepository;
    }

    public function createEmployee(array $validated, int $userId): void
    {
        try {
            DB::transaction(function () use ($validated, $userId) {
                // Todo: Add user creation logic

                $userName = $validated['basic_info']['user_name'];

                $validated['basic_info']['user_id'] = $userId;

                // upload profile image
                $validated['basic_info']['profile_image'] = $this->handleProfileImageUpload($validated, $userName);

                $employee = $this->storeEmployee($validated, $userId);

                $this->storeAllAddresses($validated, $employee);
                $this->storeContacts($validated, $employee);
                $this->storeDocuments($userName, $employee->id, $validated['basic_info']['documents'] ?? [], $userId);
                $this->storeAchievements($validated, $employee, $userName, $userId);
            });
        } catch (\Exception $exception) {
            throw new \RuntimeException('Unable to create employee at this time. Please try again later.', $exception);
        }

    }

    private function storeEmployee(array $validated, int $userId): Employee
    {
        // Remove user-related properties before storing employee details
        $employeeBasicData = $validated['basic_info'];
        unset(
            $employeeBasicData['user_name'],
        );

        // Generate employee number
        $employeeBasicData['employee_no'] = $this->generateEmployeeNumber($employeeBasicData);

        $employeeOfficialData = $validated['job_details'];

        return EmployeeManagement::create(array_merge($employeeBasicData, $employeeOfficialData, [
            'user_id' => $userId,
            'profile_completion_status' => $validated['profile_status'],
            'employment_status' => $this->getEmploymentStatus($validated['profile_status']),
            'created_by' => $userId, // Todo: Replace with actual user ID
            'created_by_name' => 'Admin', // Todo: Replace with actual user name
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
        return $profileStatus === 'draft' ? 'inactive' : 'active';
    }

    private function storeAllAddresses(array $validated, $employee): void
    {
        if ($validated['basic_info']['present_address']) {
            $this->addressRepository->storeAddress($employee, 'present', $validated['basic_info']['present_address']);
        }

        if (! $validated['basic_info']['permanent_address_same_as_present_address'] && $validated['basic_info']['permanent_address']) {
            $this->addressRepository->storeAddress($employee, 'permanent', $validated['basic_info']['permanent_address']);
        }

        if (! $validated['work_location']['is_same_as_present_address']) {
            $this->addressRepository->storeAddress($employee, 'worklocation', $validated['work_location']);
        }
    }

    private function updateAllAddresses(array $validated, $employee): void
    {
        if ($validated['basic_info']['present_address']) {
            $this->addressRepository->updateAddress($employee, 'present', $validated['basic_info']['present_address']);
        }

        if (! $validated['basic_info']['permanent_address_same_as_present_address'] && $validated['basic_info']['permanent_address']) {
            $this->addressRepository->updateAddress($employee, 'permanent', $validated['basic_info']['permanent_address']);
        }

        if (! $validated['work_location']['is_same_as_present_address']) {
            $this->addressRepository->updateAddress($employee, 'worklocation', $validated['work_location']);
        }
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

    private function storeContacts(array $validated, $employee): void
    {
        // Check if contacts exist
        if (! empty($validated['basic_info']['contacts'])) {
            foreach ($validated['basic_info']['contacts'] as $contact) {
                $this->contactRepository->storeContact($employee, $contact);
            }
        }
    }

    private function updateContacts(array $validated, $employee): void
    {
        if (! empty($validated['basic_info']['contacts'])) {
            foreach ($validated['basic_info']['contacts'] as $contact) {
                if (! empty($contact['id'])) {
                    $this->contactRepository->updateContact($contact['id'], $contact);
                } else {
                    $this->contactRepository->storeContact($employee, $contact);
                }
            }
        }
    }

    private function storeDocuments(string $userName, int $employeeId, array $documents, int $userId): void
    {
        foreach ($documents as $document) {
            $type = $document['type'];
            $expiryDate = $document['expiry_date'] ?? null;
            $files = $document['files'] ?? [];
            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    $directory = "employee/{$userName}/documents/{$type}";
                    $fileUrl = $this->storeFile($directory, $file);
                    $this->documentRepository->storeDocument($employeeId, [
                        'document_type' => $type,
                        'expiry_date' => $expiryDate,
                        'document_path' => $fileUrl,
                        'created_by' => $userId,
                    ]);
                }
            }
        }
    }

    private function updateDocuments(string $userName, int $employeeId, array $documents): void
    {
        DB::transaction(function () use ($userName, $employeeId, $documents) {
            foreach ($documents as $docData) {
                $type = $docData['type'];
                $expiryDate = $docData['expiry_date'] ?? null;
                $files = $docData['files'] ?? [];

                $existing = EmployeeDocument::firstWhere([
                    'employee_id' => $employeeId,
                    'document_type' => $type,
                ]);

                foreach ($files as $file) {
                    if ($existing) {
                        if (! empty($docData['_delete'])) {
                            $this->documentRepository->deleteDocument($existing);

                            continue;
                        }

                        // update existing
                        $payload = [
                            'document_type' => $type,
                            'expiry_date' => $expiryDate,
                            'document_path' => $file,
                            'updated_by' => 1, // TODO: use actual user ID
                        ];
                        $this->documentRepository->updateDocument($existing, $payload);
                    } else {
                        $this->storeDocuments($userName, $employeeId, [$docData]);
                    }
                }
            }
        });
    }

    private function storeAchievements(array $validated, $employee, string $userName, int $userId): void
    {
        $employeeId = $employee->id;

        // Store Education Records
        if (! empty($validated['achievements']['education'])) {
            foreach ($validated['achievements']['education'] as $education) {
                $this->educationRepository->storeEducation($employeeId, [
                    'institution_name' => $education['institution_name'],
                    'degree' => $education['degree'],
                    'field_of_study' => $education['field_of_study'],
                    'start_date' => $education['start_date'],
                    'end_date' => $education['is_running'] ? null : $education['end_date'],
                    'is_running' => $education['is_running'],
                    'created_by' => $userId,
                ]);
            }
        }

        // Store Work Experience Records
        if (! empty($validated['achievements']['work_experience'])) {
            foreach ($validated['achievements']['work_experience'] as $experience) {
                $this->experienceRepository->storeExperience($employeeId, [
                    'institution_name' => $experience['institution_name'],
                    'designation' => $experience['designation'],
                    'start_date' => $experience['start_date'],
                    'end_date' => $experience['is_running'] ? null : $experience['end_date'],
                    'is_running' => $experience['is_running'],
                    'created_by' => 1, // Todo: Replace with actual user ID
                ]);
            }
        }

        // Store Certification Records With File Upload
        if (! empty($validated['achievements']['certifications'])) {
            foreach ($validated['achievements']['certifications'] as $certification) {
                $uploadedUrls = [];

                if (! empty($certification['certificate_files']) && is_array($certification['certificate_files'])) {
                    foreach ($certification['certificate_files'] as $file) {
                        $path = $file->store("employee/{$userName}/certifications", 'public'); // or use 's3' or 'minio' disk
                        $uploadedUrls[] = Storage::disk('public')->url($path);
                    }
                }

                $this->certificationRepository->storeCertification($employeeId, [
                    'course_name' => $certification['course_name'],
                    'issuing_organization' => $certification['issuing_organization'],
                    'start_date' => $certification['start_date'],
                    'completion_date' => $certification['completion_date'],
                    'certificate_urls' => json_encode($uploadedUrls),
                    'created_by' => 1, // Todo: Replace with actual user ID
                ]);
            }
        }
    }

    private function updateAchievements(array $validated, Employee $employee, string $userName, $authId): void
    {
        $employeeId = $employee->id;
        // ----- Education -----
        foreach ($validated['achievements']['education'] ?? [] as $eduData) {
            if (! empty($eduData['_delete']) && empty($eduData['id'])) {
                continue;
            }
            $record = ! empty($eduData['id']) ? EducationalInformation::firstWhere([
                ['employee_id', $employeeId],
                ['id',          $eduData['id']],
            ]) : null;

            if (! empty($eduData['_delete']) && $record) {
                $this->educationRepository->deleteEducation($record);

                continue;
            }

            $payload = [
                'institution_name' => $eduData['institution_name'],
                'degree' => $eduData['degree'],
                'field_of_study' => $eduData['field_of_study'],
                'start_date' => $eduData['start_date'],
                'end_date' => $eduData['is_running'] ? null : $eduData['end_date'],
                'is_running' => $eduData['is_running'],
                'updated_by' => $authId,
            ];

            if ($record) {
                $this->educationRepository->updateEducation($record, $payload);
            } else {
                $payload['created_by'] = $authId;
                $this->educationRepository->storeEducation($employeeId, $payload);
            }
        }
        // ----- Work Experience -----
        foreach ($validated['achievements']['work_experience'] ?? [] as $expData) {
            if (! empty($expData['_delete']) && empty($expData['id'])) {
                continue;
            }

            $record = ! empty($expData['id']) ? ProfessionalExperience::firstWhere([
                ['employee_id', $employeeId],
                ['id',          $expData['id']],
            ]) : null;

            if (! empty($expData['_delete']) && $record) {
                $this->experienceRepository->deleteExperience($record);

                continue;
            }

            $payload = [
                'institution_name' => $expData['institution_name'],
                'designation' => $expData['designation'],
                'start_date' => $expData['start_date'],
                'end_date' => $expData['is_running'] ? null : $expData['end_date'],
                'is_running' => $expData['is_running'],
                'updated_by' => $authId,
            ];

            if ($record) {
                $this->experienceRepository->updateExperience($record, $payload);
            } else {
                $payload['created_by'] = $authId;
                $this->experienceRepository->storeExperience($employeeId, $payload);
            }
        }

        // ----- Certifications -----
        foreach ($validated['achievements']['certifications'] ?? [] as $certData) {
            // Skip if marked for deletion but no existing record
            if (! empty($certData['_delete']) && empty($certData['id'])) {
                continue;
            }

            $record = ! empty($certData['id']) ? Certification::firstWhere([
                ['employee_id', $employeeId],
                ['id',          $certData['id']],
            ]) : null;

            // If marked for deletion and record exists, delete it
            if (! empty($certData['_delete']) && $record) {
                $this->certificationRepository->deleteCertification($record);

                continue;
            }

            $payload = [
                'course_name' => $certData['course_name'],
                'issuing_organization' => $certData['issuing_organization'],
                'start_date' => $certData['start_date'],
                'completion_date' => $certData['completion_date'],
                'certificate_urls' => $certData['certificate_urls'],
                'updated_by' => $authId,
            ];

            if ($record) {
                $this->certificationRepository->updateCertification($record, $payload);
            } else {
                $payload['created_by'] = $authId;
                $this->certificationRepository->storeCertification($employeeId, $payload);
            }
        }
    }

    private function applyEmployeeUpdate(Employee $employee, array $validated): void
    {
        $basicData = $validated['basic_info'];
        unset($basicData['user_name']); // not stored on employee

        $oldType = $employee->identity_type;
        $newType = $basicData['identity_type'] ?? $oldType;

        if ($newType === 'automatic') {
            $basicData['employee_no'] = $this->generateEmployeeNumber($basicData);
        }
        $officialData = $validated['job_details'];
        $updateData = array_merge(
            $basicData,
            $officialData,
            [
                'profile_completion_status' => $validated['profile_status'],
                'employment_status' => $this->getEmploymentStatus($validated['profile_status']),
                'updated_by' => 1, // TODO: replace with auth user ID
                'updated_by_name' => 'Admin',
            ]
        );
        EmployeeManagement::update($employee, $updateData);
    }

    public function updateEmployee(array $validated, int $employeeId, $authId): void
    {
        try {
            DB::transaction(function () use ($validated, $employeeId, $authId) {
                // Todo: Add user creation logic
                $employee = $this->model->findOrFail($employeeId);

                $userName = $validated['basic_info']['user_name'] ?? '';

                $validated['basic_info']['user_id'] = $authId;

                // upload profile image
                if (request()->hasFile('basic_info.profile_image')) {
                    $validated['basic_info']['profile_image'] = $this->handleProfileImageUpload($validated, $userName);
                } else {
                    unset($validated['basic_info']['profile_image']);
                }

                $this->applyEmployeeUpdate($employee, $validated);

                $this->updateAllAddresses($validated, $employee);
                $this->updateContacts($validated, $employee);
                $this->updateDocuments($userName, $employee->id, $validated['basic_info']['documents'] ?? []);
                $this->updateAchievements($validated, $employee, $userName, $authId);
            });
        } catch (\Exception $exception) {
            throw new \RuntimeException('Unable to update employee at this time. Please try again later.', $exception);
        }
    }
}
