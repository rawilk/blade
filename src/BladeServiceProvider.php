<?php

declare(strict_types=1);

namespace Rawilk\Blade;

use Illuminate\Support\Facades\Blade as LaravelBlade;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\ComponentAttributeBag;
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

    public function packageBooted(): void
    {
        $this->bootBladeComponents();

        $this->registerMacros();
    }

    private function bootBladeComponents(): void
    {
        // Allows us to not have to register every single blade component.
        LaravelBlade::componentNamespace('Rawilk\\Blade\\Components', 'blade');

        // Register short names for certain components.
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $prefix = config('blade.component_prefix', '');

            foreach (config('blade.components', []) as $alias => $component) {
                $blade->component($component, $alias, $prefix);
            }
        });
    }

    private function registerMacros(): void
    {
        if (! ComponentAttributeBag::hasMacro('hasStartsWith')) {
            ComponentAttributeBag::macro('hasStartsWith', function ($key) {
                return (bool) $this->whereStartsWith($key)->first();
            });
        }
    }
}
