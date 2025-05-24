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
 * @property int         $designation_id
 * @property string      $employment_type
 * @property string|null $comment
 * @property string      $status
 * @property Carbon|null $start_date
 * @property Carbon|null $end_date
 * @property string      $status_label
 * @property string      $formatted_start_date
 * @property string      $formatted_end_date
 */
class EmploymentHistory extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'designation_id',
        'employment_type',
        'comment',
        'status',
        'start_date',
        'end_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = ['status_label', 'formatted_start_date', 'formatted_end_date'];

    /**
     * Get the employee associated with the employment history.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the designation of the employment history.
     */
    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    /**
     * Get the status label for the employment history.
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => match ($this->status) {
                'active' => 'Active',
                'inactive' => 'Inactive',
                'terminated' => 'Terminated',
                default => 'Unknown',
            }
        );
    }

    /**
     * Get the formatted start date.
     */
    protected function formattedStartDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->start_date->format('d-m-Y')
        );
    }

    /**
     * Get the formatted end date.
     */
    protected function formattedEndDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->end_date ? $this->end_date->format('d-m-Y') : 'Present'
        );
    }
}
