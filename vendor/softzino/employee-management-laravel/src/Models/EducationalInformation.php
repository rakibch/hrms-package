<?php

namespace Softzino\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Softzino\EmployeeManagement\Base\BaseModel;

class EducationalInformation extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'educational_informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'institution_name',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'grade',
        'certificate_file_path',
        'is_running',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'grade' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_running' => 'boolean',
    ];

    /**
     * The attributes that should be appended to the model's array or JSON representation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'formatted_grade',
    ];

    /**
     * Get the employee that the educational information belongs to.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the formatted grade attribute.
     */
    public function getFormattedGradeAttribute(): ?string
    {
        return isset($this->grade) ? number_format((float) $this->grade, 2) : null;
    }
}
