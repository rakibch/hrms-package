<?php

namespace Softzino\StHrmsCore\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Softzino\StHrmsCore\StHrmsCore
 */
class StHrmsCore extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Softzino\StHrmsCore\StHrmsCore::class;
    }
}
