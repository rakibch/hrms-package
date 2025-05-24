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
use Softzino\EmployeeManagement\Database\Factories\DesignationFactory;

/**
 * @property string      $name
 * @property bool        $is_active
 * @property int|null    $reporting_to_designation_id
 * @property int|null    $created_by
 * @property string|null $created_by_name
 * @property int|null    $updated_by
 * @property string|null $updated_by_name
 * @property-read string $status_label
 * @property-read Collection|Department[] $departments
 * @property-read Collection|Designation[] $subordinates
 * @property-read Designation|null $reportingTo
 */
class Designation extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'is_active',
        'reporting_to_designation_id',
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

    protected static function newFactory(): DesignationFactory
    {
        return DesignationFactory::new();
    }

    /**
     * Get the departments the designation belongs to.
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(
            Department::class, DepartmentDesignation::getTableName(),
            'designation_id',
            'department_id'
        )->withTimestamps();
    }

    /**
     * Get the employees that belong to this designation.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'designation_id');
    }

    /**
     * Get designations that report to this designation.
     */
    public function subordinates(): HasMany
    {
        return $this->hasMany(self::class, 'reporting_to_designation_id');
    }

    /**
     * Get the designation this one reports to.
     */
    public function reportingTo(): BelongsTo
    {
        return $this->belongsTo(self::class, 'reporting_to_designation_id');
    }

    /**
     * Get the status label for the designation.
     */
    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn (): string => $this->is_active ? 'Active' : 'Inactive');
    }

    /**
     * Scope a query to only include active designations.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive designations.
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('is_active', false);
    }
}
