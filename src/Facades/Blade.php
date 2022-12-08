<?php

namespace Rawilk\Blade\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rawilk\Blade\Blade
 */
class Blade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Rawilk\Blade\Blade::class;
    }
}
