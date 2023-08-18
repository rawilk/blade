<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Disclosure;

use Illuminate\Support\Arr;
use Rawilk\Blade\Components\BladeComponent;

class AccordionItem extends BladeComponent
{
    public function __construct(
        public ?string $title = '',
        public string $titleTag = 'h3',
        public ?string $titleClasses = null,
        public ?bool $xCollapse = null,
        public ?string $icon = null,
        public ?bool $rotateIcon = null,
        public ?bool $iconLeft = null,
        public ?bool $flush = null,
        public bool $borderless = false,

        // Region role not recommended if more than 6 panels are present.
        public bool $regionRole = true,
    ) {
        $this->xCollapse = $xCollapse ?? config('blade.defaults.accordion.x_collapse', true);
        $this->icon = $icon ?? config('blade.defaults.accordion.button_icon', 'heroicon-m-chevron-down');

        // There's no point in querying the config if we don't have an icon to use.
        if ($this->icon) {
            $this->rotateIcon = $rotateIcon ?? config('blade.defaults.accordion.rotate_button_icon', true);
            $this->iconLeft = $iconLeft ?? config('blade.defaults.accordion.icon_left', false);
        }

        // These properties will be overridden if the accordion item is within an accordion group.
        $this->flush = $flush ?? config('blade.defaults.accordion.flush', false);
    }

    public function classes(array $options = []): string
    {
        $flush = $this->componentIsFlush($options['flush'] ?? null);

        return Arr::toCssClasses([
            'accordion',
            'accordion--flush' => $flush,
            'accordion--borderless' => $flush && $this->borderless,
        ]);
    }

    public function renderRegionRole(bool $parentRegionRole = null): bool
    {
        return $parentRegionRole ?? $this->regionRole;
    }

    public function componentIsFlush(?bool $parentIsFlush): bool
    {
        return $parentIsFlush ?? $this->flush;
    }
}
