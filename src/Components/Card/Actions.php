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
    ) {
    }
}
