<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
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
