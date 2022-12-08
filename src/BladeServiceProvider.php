<?php

namespace Rawilk\Blade;

use Rawilk\Blade\Commands\BladeCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BladeServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('blade')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_blade_table')
            ->hasCommand(BladeCommand::class);
    }
}
