<?php

namespace Softzino\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Softzino\EmployeeManagement\Base\BaseModel;
use Softzino\EmployeeManagement\Database\Factories\DepartmentFactory;

/**
 * @property string      $name
 * @property int|null    $head_id
 * @property bool        $is_active
 * @property int|null    $created_by
 * @property string|null $created_by_name
 * @property int|null    $updated_by
 * @property string|null $updated_by_name
 * @property-read string $status_label
 * @property-read Collection|Employee[] $employees
 * @property-read Collection|Designation[] $designations
 * @property-read Employee|null $head
 */
class Department extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'head_id',
        'is_active',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be appended to the model's array or JSON representation.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'status_label',
    ];

    protected static function newFactory(): DepartmentFactory
    {
        return DepartmentFactory::new();
    }

    /**
     * Get the user who is the head of the department.
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'head_id');
    }

    /**
     * Get related designations (Many-to-Many).
     */
    public function designations(): BelongsToMany
    {
        return $this->belongsToMany(
            Designation::class,
            config('employee-management.database.table_prefix') . 'department_designation',
            'department_id',
            'designation_id'
        )->withTimestamps();
    }

    /**
     * Get related employees.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    /**
     * Get the status label for the department.
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn (): string => $this->is_active ? 'Active' : 'Inactive');
    }

    /**
     * Scope a query to only include active departments.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive departments.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }
}
