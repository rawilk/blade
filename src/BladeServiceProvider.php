<?php

namespace Rawilk\Blade;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Rawilk\Blade\Commands\BladeCommand;

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
