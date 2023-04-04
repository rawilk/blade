<?php

declare(strict_types=1);

namespace Rawilk\Blade;

use Illuminate\Support\Facades\Blade as LaravelBlade;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\ComponentAttributeBag;
use Rawilk\Blade\Controllers\BladeJavaScriptAssets;
use Rawilk\Blade\Support\BladeTagCompiler;
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
        $this->bootDirectives();
        $this->registerMacros();
        $this->bootRoutes();
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

    private function bootDirectives(): void
    {
        // Our custom tag compiler will allow us to use self-closing tags instead of a directive,
        // i.e. <blade:scripts /> instead of @bladeScripts.
        if (method_exists($this->app['blade.compiler'], 'precompiler')) {
            $this->app['blade.compiler']->precompiler(function ($string) {
                return app(BladeTagCompiler::class)->compile($string);
            });
        }

        LaravelBlade::directive('bladeScripts', function (string $expression) {
            return "<?php echo \\Rawilk\\Blade\\Facades\\Blade::javaScript({$expression}); ?>";
        });
    }

    private function bootRoutes(): void
    {
        Route::get('/blade/blade.js', [BladeJavaScriptAssets::class, 'source']);
        Route::get('/blade/blade.js.map', [BladeJavaScriptAssets::class, 'maps']);
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
