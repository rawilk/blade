<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Button;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Rawilk\Blade\Components\BladeComponent;
use Rawilk\Blade\Concerns\HandlesExternalLinks;
use Rawilk\Blade\Concerns\HasExtraAttributes;
use Throwable;

class Button extends BladeComponent
{
    use HandlesExternalLinks;
    use HasExtraAttributes;

    protected bool $hideExternalIndicator = true;

    protected ?bool $isDisabled = null;

    protected null|bool|string $wireTarget = null;

    public function __construct(
        public ?string $color = null,
        public ?string $variant = null,
        public bool $block = false,
        public ?string $size = null,
        public bool|string|null $ripple = null,
        public bool|string|null $rippleFocus = null,
        public ?bool $pill = null,

        // Named icon props. Using these props will override the icon slots.
        public ?string $leftIcon = null,
        public ?string $rightIcon = null,

        // This option is only available to regular buttons (not buttons with href applied)
        public ?bool $showLoader = null,

        // Link specific options
        public ?string $href = null,
        public bool $noReferrer = false, // Only applies to external links

        // Extra attributes
        null|array|Collection $extraAttributes = null,
    ) {
        $this->size = $size ?? config('blade.defaults.button.size', 'md');
        $this->color = $color ?? config('blade.defaults.button.color', 'slate');
        $this->variant = $variant ?? config('blade.defaults.button.variant', 'contained');
        $this->ripple = $ripple ?? config('blade.defaults.button.ripple');
        $this->rippleFocus = $rippleFocus ?? config('blade.defaults.button.ripple_focus');
        $this->showLoader = $showLoader ?? config('blade.defaults.button.show_loader');
        $this->pill = $pill ?? config('blade.defaults.button.pill');

        $this->setExtraAttributes($extraAttributes);
    }

    public function buttonClass(): string
    {
        return Arr::toCssClasses([
            'button',
            $this->variantCssClass(),
            'pointer-events-none' => $this->href && $this->isDisabled(),
            'w-full button--block' => $this->block,
            "button--{$this->color}",
            "button--{$this->size}" => $this->size,
            'button--pill' => $this->pill,
        ]);
    }

    public function tag(): string
    {
        return $this->href ? 'a' : 'button';
    }

    protected function variantCssClass(): string
    {
        return match ($this->variant) {
            'outline', 'outlined' => 'button-outlined',
            'text' => 'button-text',
            default => 'button-contained',
        };
    }

    public function isDisabled(): bool
    {
        if ($this->isDisabled !== null) {
            return $this->isDisabled;
        }

        return $this->isDisabled = ($this->attributes->has('disabled') && $this->attributes->get('disabled'));
    }

    public function shouldShowLoader(): bool
    {
        // Loading indicator is only available to regular buttons (not buttons with href applied).
        if ($this->tag() === 'a') {
            return false;
        }

        // If the showLoader property is set to a boolean value, use that.
        // Otherwise, check if the button is wired to a Livewire component.
        return $this->showLoader ?? (bool) $this->wireTarget();
    }

    public function wireTarget(): string|bool
    {
        if ($this->wireTarget !== null) {
            return $this->wireTarget;
        }

        $wireTarget = false;

        // Wrapped in a try-catch in case livewire is not installed.
        try {
            // First check if user explicitly specified a different wire target.
            $wireTarget = $this->attributes->wire('target')->value();

            // If no wire target is specified, use the wire:click as the wire target.
            // This is the intended behavior for most buttons.
            if (! $wireTarget) {
                $wireTarget = $this->attributes->wire('click')->value();
            }
        } catch (Throwable) {
        }

        return $this->wireTarget = $wireTarget;
    }
}
