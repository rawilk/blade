<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Navigation;

use Illuminate\Support\Arr;
use Rawilk\Blade\Components\BladeComponent;

use function Filament\Support\get_color_css_variables;

class InnerNavItem extends BladeComponent
{
    public bool $active;

    public function __construct(
        public string $href = '#',
        public $icon = false,
        bool $active = null,
        public ?bool $filament = null,
        public ?string $color = null,
    ) {
        $this->filament ??= config('blade.filament', false);
        $this->color ??= config('blade.defaults.inner-nav-item.color', 'primary');

        $this->active = is_null($active)
            ? request()?->fullUrlIs($href) === true
            : $active;
    }

    public function linkClass(): string
    {
        return Arr::toCssClasses([
            'inner-nav-link',
            'relative',
            'group flex gap-x-3 rounded-md py-2 pl-2 pr-3 text-sm leading-6 font-semibold',
            'bg-gray-100 text-custom-600 dark:bg-gray-800 dark:text-white' => $this->active && $this->filament,
            'text-gray-700 hover:text-custom-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-800' => ! $this->active && $this->filament,
        ]);
    }

    public function linkStyles(): string
    {
        return Arr::toCssStyles([
            $this->filament ? get_color_css_variables($this->color, [600]) : null,
        ]);
    }

    public function iconClass(): string
    {
        return Arr::toCssClasses([
            'inner-nav-item__icon',
            'text-custom-600 dark:text-white' => $this->active && $this->filament,
            'text-gray-400 group-hover:text-custom-600 dark:group-hover:text-white' => ! $this->active && $this->filament,
        ]);
    }
}
