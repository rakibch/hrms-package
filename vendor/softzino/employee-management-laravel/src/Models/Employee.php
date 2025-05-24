<?php

namespace Softzino\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Softzino\EmployeeManagement\Base\BaseModel;

/**
 * @property int         $user_id
 * @property string|null $identity_type
 * @property string|null $employee_no
 * @property Carbon|null $join_date
 * @property string      $first_name
 * @property string      $last_name
 * @property string|null $profile_image
 * @property Carbon|null $dob
 * @property string|null $gender
 * @property string|null $marital_status
 * @property string|null $religion
 * @property string|null $blood_group
 * @property string|null $personal_contact_no
 * @property string|null $personal_email
 * @property bool        $permanent_address_same_as_present_address
 * @property bool        $work_address_same_as_present_address
 * @property string|null $job_type
 * @property int|null    $department_id
 * @property int|null    $designation_id
 * @property string|null $employment_type
 * @property string|null $official_contact_no
 * @property string|null $official_email
 * @property string|null $profile_completion_status
 * @property string|null $employment_status
 * @property-read string $full_name
 * @property-read string $status_label
 */
class Employee extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'identity_type',
        'employee_no',
        'join_date',
        'first_name',
        'last_name',
        'profile_image',
        'dob',
        'gender',
        'marital_status',
        'religion',
        'blood_group',
        'personal_contact_no',
        'personal_email',
        'permanent_address_same_as_present_address',
        'work_address_same_as_present_address',
        'job_type',
        'department_id',
        'designation_id',
        'employment_type',
        'official_contact_no',
        'official_email',
        'profile_completion_status',
        'employment_status',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $casts = [
        'dob' => 'date',
        'join_date' => 'date',
        'permanent_address_same_as_present_address' => 'boolean',
        'work_address_same_as_present_address' => 'boolean',
    ];

    protected $appends = ['status_label', 'full_name'];

    public function contacts(): HasMany
    {
        return $this->hasMany(EmployeeContact::class, 'employee_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function educationalInformations(): HasMany
    {
        return $this->hasMany(EducationalInformation::class);
    }

    public function professionalExperiences(): HasMany
    {
        return $this->hasMany(ProfessionalExperience::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function employmentHistories(): HasMany
    {
        return $this->hasMany(EmploymentHistory::class);
    }

    public function employeeDocuments(): HasMany
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    /**
     * Get full name of the employee.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => trim("{$this->first_name} {$this->last_name}")
        );
    }

    /**
     * Get the status label for employment status.
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->employment_status) {
                'active' => 'Active',
                'inactive' => 'Inactive',
                'terminated' => 'Terminated',
                default => 'Unknown',
            }
        );
    }
}
