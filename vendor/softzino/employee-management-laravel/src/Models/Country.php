<?php

namespace Softzino\EmployeeManagement\Models;

use Softzino\EmployeeManagement\Base\BaseModel;

class Country extends BaseModel
{
    protected $fillable = [
        'name',
        'iso2_code',
        'iso3_code',
        'phone_code',
        'phone_regex',
        'currency_code',
        'currency_symbol',
        'timezone',
        'currency_name',
    ];

    // Disable auto-incrementing ID if using BIG SERIAL
    protected $primaryKey = 'id';

    public $timestamps = true;

    // Set the date format for timestamps
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
