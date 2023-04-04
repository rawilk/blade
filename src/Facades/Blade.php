<?php

declare(strict_types=1);

namespace Rawilk\Blade\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rawilk\Blade\Blade
 *
 * @method static string javaScript(array $options = [])
 */
class Blade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Rawilk\Blade\Blade::class;
    }
}
