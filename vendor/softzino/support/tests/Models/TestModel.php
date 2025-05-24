<?php

namespace Softzino\Support\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = 'test_models';

    protected $fillable = [
        'name',
        'email',
        'status'
    ];
}
