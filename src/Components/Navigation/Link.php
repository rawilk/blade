<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Navigation;

use Illuminate\Support\Arr;
use Rawilk\Blade\Components\BladeComponent;
use Rawilk\Blade\Concerns\HandlesExternalLinks;

class Link extends BladeComponent
{
    use HandlesExternalLinks;

    public function __construct(
        public ?string $href = '#',
        public ?bool $appLink = null,
        public ?bool $dark = null,

        // External link only options
        public bool $noReferrer = false,
        public ?bool $hideExternalIndicator = null,

        // Named icon props. Using these props will override the icon slots.
        public ?string $leftIcon = null,
        public ?string $rightIcon = null,
    ) {
        $this->appLink = $appLink ?? config('blade.defaults.link.app_link', true);
        $this->dark = $dark ?? config('blade.defaults.link.dark', false);
        $this->hideExternalIndicator = $hideExternalIndicator ?? config('blade.defaults.link.hide_external_indicator', false);
    }

    public function classes(): string
    {
        return Arr::toCssClasses([
            'relative',
            'app-link' => $this->appLink,
            'app-link--dark' => $this->appLink && $this->dark,
        ]);
    }
}
