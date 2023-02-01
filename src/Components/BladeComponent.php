<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

abstract class BladeComponent extends Component
{
    public function render()
    {
        return view("blade::components.{$this::getName()}");
    }

    /**
     * This method is derived from livewire/livewire from Component.php.
     */
    public static function getName(): string
    {
        $namespace = collect(explode('.', str_replace(['/', '\\'], '.', 'Rawilk\\Blade\\Components')))
            ->map([Str::class, 'kebab'])
            ->implode('.');

        $fullName = collect(explode('.', str_replace(['/', '\\'], '.', static::class)))
            ->map([Str::class, 'kebab'])
            ->implode('.');

        if (str($fullName)->startsWith($namespace)) {
            return (string) str($fullName)->substr(strlen($namespace) + 1);
        }

        return $fullName;
    }
}
