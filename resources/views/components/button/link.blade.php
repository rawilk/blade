<button
    {{ $attributes->merge(['type' => 'button', 'class' => $buttonClass()]) }}
    @if ($wireTarget())
        wire:target="{{ $wireTarget() }}"
        wire:loading.attr="disabled"
        wire:loading.class="button--busy"
    @endif
    @if ($ripple)
        {{ is_bool($ripple) ? 'x-ripple' : "x-ripple.{$ripple}" }}
    @endif
    @if ($isDisabled())
        tabindex="-1"
    @endif
>
    @if ($shouldShowLoader())
        <div class="flex items-center justify-center absolute inset-0 opacity-0 transition-opacity button__loader"
             @if ($wireTarget())
                 wire:loading.class.delay="opacity-100"
                 wire:loading.class.remove.delay="opacity-0"
                 wire:target="{{ $wireTarget() }}"
             @endif
        >
            <x-blade::loader.ball-clip-rotate-pulse />
        </div>
    @endif

    <span class="button__content inline-flex items-center transition-all"
          @if ($shouldShowLoader() && $wireTarget())
              wire:loading.class.delay="invisible"
              wire:target="{{ $wireTarget() }}"
          @endif
    >
        @if ($iconLeft ?? $leftIcon ?? false)
            <span class="link__icon link__icon--left mr-1" aria-hidden="true">
                @if ($leftIcon)
                    <x-dynamic-component :component="$leftIcon" />
                @else
                    {{ $iconLeft }}
                @endif
            </span>
        @endif

        {{ $slot }}

        @if ($iconRight ?? $rightIcon ?? false)
            <span class="link__icon link__icon--right ml-1" aria-hidden="true">
                @if ($rightIcon)
                    <x-dynamic-component :component="$rightIcon" />
                @else
                    {{ $iconRight }}
                @endif
            </span>
        @endif
    </span>
</button>
