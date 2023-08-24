<li>
    <a href="{{ $href }}"
       {{ $attributes->class($linkClass())->style($linkStyles()) }}
    >
        @if ($icon)
            <x-dynamic-component
                :component="$filament ? 'filament::icon' : $icon"
                :icon="$icon"
                :class="$iconClass()"
                aria-hidden="true"
            />
        @endif

        <span class="truncate w-full hover:text-clip hover:whitespace-normal">{{ $slot }}</span>
    </a>
</li>
