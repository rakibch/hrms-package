<?php

namespace Softzino\EmployeeManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Softzino\EmployeeManagement\Base\BaseModel;

class Address extends BaseModel
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'addressable_type', // Polymorphic relation type
        'addressable_id',   // Polymorphic relation ID
        'type',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'lat',
        'lon',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lat' => 'float',
        'lon' => 'float',
    ];

    /**
     * Get the parent addressable model (e.g., Employee, Company, etc.).
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the country associated with the address.
     */
    public function countryRelation(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country');
    }
}
