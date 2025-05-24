<?php

namespace Softzino\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Softzino\EmployeeManagement\Base\BaseModel;

class DepartmentDesignation extends BaseModel
{
    protected $table = 'department_designation';

    protected $fillable = [
        'department_id',
        'designation_id',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }
}
