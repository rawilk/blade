<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Button;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Icon extends Button
{
    public function __construct(
        public ?string $color = null,
        public ?string $variant = null,
        public ?string $size = null,
        public bool|string|null $ripple = null,
        public bool|string|null $rippleFocus = null,

        // This option is only available to regular buttons (not buttons with href applied)
        public ?bool $showLoader = null,

        // Link specific options
        public ?string $href = null,
        public bool $noReferrer = false, // Only applies to external links

        // Named icon prop. If specified, default slot will be ignored.
        public ?string $icon = null,

        // Extra attributes
        null|array|Collection $extraAttributes = null,
    ) {
        parent::__construct(
            color: $color,
            variant: $variant,
            size: $size,
            ripple: $ripple,
            rippleFocus: $rippleFocus,
            showLoader: $showLoader,
            href: $href,
            noReferrer: $noReferrer,
            extraAttributes: $extraAttributes,
        );
    }

    public function buttonClass(): string
    {
        return Arr::toCssClasses([
            'button button--icon',
            $this->variantCssClass(),
            'pointer-events-none' => $this->href && $this->isDisabled(),
            "button--{$this->color}",
            "button--{$this->size}" => $this->size,
        ]);
    }
}
