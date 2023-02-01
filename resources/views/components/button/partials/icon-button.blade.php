<button
    {{ $attributes->merge(['type' => 'button', 'class' => $buttonClass()]) }}
    @include('blade::components.button.partials.attributes')
    @if ($wireTarget())
        wire:target="{{ $wireTarget() }}"
        wire:loading.attr="disabled"
        wire:loading.class="button--busy"
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

    <span class="button__content transition-all"
          @if ($shouldShowLoader() && $wireTarget())
              wire:loading.class.delay="invisible"
              wire:target="{{ $wireTarget() }}"
          @endif
    >
        @if ($icon)
            <x-dynamic-component :component="$icon" />
        @else
            {{ $slot }}
        @endif
    </span>
</button>
