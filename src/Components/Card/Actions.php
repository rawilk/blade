<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Card;

use Rawilk\Blade\Components\BladeComponent;

class Actions extends BladeComponent
{
    public function __construct(
        public ?string $title = null,
        public ?string $subtitle = null,
        public bool $wrap = true,
        public ?string $collapseIcon = null,
        public ?bool $ripple = null,
    ) {
    }

    // We are doing this in a method to avoid looking up the config when the card is not set to
    // be collapsible.
    public function getCollapseIcon(bool $collapse): ?string
    {
        if (! $collapse) {
            return null;
        }

        return $this->collapseIcon ?? config('blade.defaults.card.collapse_icon');
    }

    public function shouldRipple(bool $collapse): bool
    {
        if (! $collapse) {
            return false;
        }

        return $this->ripple ?? config('blade.defaults.card.ripple', true);
    }
}
