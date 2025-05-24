<?php

namespace Softzino\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Softzino\EmployeeManagement\Base\BaseModel;

/**
 * @property int         $employee_id
 * @property string      $course_name
 * @property string      $issuing_organization
 * @property Carbon|null $start_date
 * @property Carbon|null $completion_date
 * @property array|null  $certificate_urls
 * @property int|null    $created_by
 * @property int|null    $updated_by
 */
class Certification extends BaseModel
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'certifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'course_name',
        'issuing_organization',
        'start_date',
        'completion_date',
        'certificate_urls',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'completion_date' => 'date',
        'certificate_urls' => 'array',
    ];

    /**
     * Get the employee that the certification belongs to.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the formatted start date attribute.
     */
    protected function formattedStartDate(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->start_date?->format('Y-m-d'));
    }

    /**
     * Get the formatted completion date attribute.
     */
    protected function formattedCompletionDate(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->completion_date?->format('Y-m-d'));
    }
}
