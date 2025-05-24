<?php

namespace Softzino\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Softzino\EmployeeManagement\Base\BaseModel;

class EmployeeDocument extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'document_type',
        'document_path',
        'expiry_date',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the employee associated with the employee document.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
