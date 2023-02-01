<span class="button__content inline-flex items-center transition-all"
      @if ($shouldShowLoader() && $wireTarget())
          wire:loading.class.delay="invisible"
          wire:target="{{ $wireTarget() }}"
      @endif
>
    @if ($iconLeft ?? $leftIcon ?? false)
        <span class="button__icon button__icon--left" aria-hidden="true">
            @if ($leftIcon)
                <x-dynamic-component :component="$leftIcon" />
            @else
                {{ $iconLeft }}
            @endif
        </span>
    @endif

    {{ $slot }}

    @if ($iconRight ?? $rightIcon ?? false)
        <span class="button__icon button__icon--right" aria-hidden="true">
            @if ($rightIcon)
                <x-dynamic-component :component="$rightIcon" />
            @else
                {{ $iconRight }}
            @endif
        </span>
    @endif
</span>
