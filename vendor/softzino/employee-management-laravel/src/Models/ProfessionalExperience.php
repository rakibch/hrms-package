<?php

namespace Softzino\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Softzino\EmployeeManagement\Base\BaseModel;

/**
 * @property int         $id
 * @property int         $employee_id
 * @property string      $institution_name
 * @property string      $designation
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property bool        $is_running
 * @property int|null    $created_by
 * @property int|null    $updated_by
 * @property string      $formatted_start_date
 * @property string      $formatted_end_date
 */
class ProfessionalExperience extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'institution_name',
        'designation',
        'start_date',
        'end_date',
        'is_running',
        'created_by',
        'updated_by',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * @var array<int, string>
     */
    protected $appends = [
        'formatted_start_date',
        'formatted_end_date',
    ];

    /**
     * Get the employee that the professional experience belongs to.
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
        return Attribute::make(
            get: fn () => $this->start_date ? $this->start_date->format('Y-m-d') : ''
        );
    }

    /**
     * Get the formatted end date attribute.
     */
    protected function formattedEndDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->end_date ? $this->end_date->format('Y-m-d') : ''
        );
    }
}
