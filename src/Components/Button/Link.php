<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Button;

use Illuminate\Support\Arr;

/**
 * This component is useful for creating buttons that look like links.
 * It is basically a way to not have to write `.prevent` on wire:clicks,
 * and it is more semantic than using an `<a>` tag.
 */
class Link extends Button
{
    public function __construct(
        public bool $block = false,
        public bool|string|null $ripple = null,
        public ?bool $showLoader = null,
        public ?bool $appLink = null,
        public ?bool $dark = null,

        // Named icon props. Using these props will override the icon slots.
        public ?string $leftIcon = null,
        public ?string $rightIcon = null,
    ) {
        parent::__construct(
            block: $block,
            ripple: $ripple,
            leftIcon: $leftIcon,
            rightIcon: $rightIcon,
            showLoader: $showLoader,
        );

        $this->appLink = $appLink ?? config('blade.defaults.link.app_link', true);
        $this->dark = $dark ?? config('blade.defaults.link.dark', false);
    }

    public function buttonClass(): string
    {
        return Arr::toCssClasses([
            'relative',
            'button--link',
            'w-full button--block' => $this->block,
            'app-link' => $this->appLink,
            'app-link--dark' => $this->appLink && $this->dark,
        ]);
    }
}
