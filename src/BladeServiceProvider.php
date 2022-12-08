<?php

declare(strict_types=1);

namespace Rawilk\Blade;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BladeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('blade')
            ->hasConfigFile()
            ->hasViews();
    }
}
