<li>
    <a href="{{ $href }}"
       {{ $attributes->class($linkClass())->style($linkStyles()) }}
    >
        @if ($icon)
            @if ($filament)
                <x-filament::icon
                    :icon="$icon"
                    :class="$iconClass()"
                />
            @else
                <x-dynamic-component
                    :component="$icon"
                    :class="$iconClass()"
                    aria-hidden="true"
                />
            @endif

            <span class="truncate w-full hover:text-clip hover:whitespace-normal">{{ $slot }}</span>
        @endif
    </a>
</li>
