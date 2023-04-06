<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Disclosure;

use Rawilk\Blade\Components\BladeComponent;

class Accordion extends BladeComponent
{
    public function __construct(
        public ?bool $isFlush = null,

        // Region role is not recommended if more than 6 panels are present.
        // Value will override child accordions if set to a boolean.
        public ?bool $useRegionRole = null,
    ) {
        $this->isFlush = $isFlush ?? config('blade.defaults.accordion.flush', false);
    }
}
