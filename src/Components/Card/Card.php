<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Card;

use Illuminate\Support\Arr;
use Rawilk\Blade\Components\BladeComponent;

class Card extends BladeComponent
{
    // Types (for header styling)
    public const ERROR = 'error';

    public const SUCCESS = 'success';

    public function __construct(
        public string $type = '',
        public mixed $header = false,
        public mixed $footer = false,
        public ?string $bodyClass = null,
        public ?bool $flush = null,
        public ?bool $stickyHeader = null,
        public ?string $stickyHeaderOffset = null,
        public ?string $href = null,
    ) {
        $this->flush = $flush ?? config('blade.defaults.card.flush', false);
        $this->stickyHeader = $stickyHeader ?? config('blade.defaults.card.sticky_header', true);
        $this->stickyHeaderOffset = $stickyHeaderOffset ?? config('blade.defaults.card.sticky_header_offset', '1rem');
    }

    public function cardClass(): string
    {
        return Arr::toCssClasses([
            'card',
            'has-link' => $this->href,
        ]);
    }

    public function headerClass(): string
    {
        $type = $this->type ?: 'default';

        return Arr::toCssClasses([
            'card-header',
            "card-header--{$type}",
            'sticky top-[--sticky-header-offset] z-[999]' => $this->stickyHeader,
        ]);
    }
}
