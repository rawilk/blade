<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Card;

use Illuminate\Support\Arr;

class Image extends Card
{
    public function __construct(
        string $bodyClass = null,
        bool $flush = null,
        string $href = null,

        // Image specific
        public string $src = '',
        public string $alt = '',
        public string $imagePosition = 'top',
    ) {
        parent::__construct(
            bodyClass: $bodyClass,
            flush: $flush,
            href: $href,
        );
    }

    public function cardClass(): string
    {
        return Arr::toCssClasses([
            'card',
            'has-link' => $this->href,
            'card--image',
            $this->positionClass(),
        ]);
    }

    private function positionClass(): string
    {
        return match ($this->imagePosition) {
            'left' => 'card--image__left',
            'right' => 'card--image__right',
            'bottom' => 'card--image__bottom',
            default => 'card--image__top',
        };
    }
}
