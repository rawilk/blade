<a href="{{ $href }}"
   @if ($isExternalLink()) rel="{{ $rel($attributes->get('rel')) }}" @endif
   {{ $attributes->class($classes()) }}
>
    <span class="inline-flex items-center">
        @if ($iconLeft ?? $leftIcon ?? false)
            <span class="link__icon link__icon--left mr-1.5" aria-hidden="true">
                @if ($leftIcon)
                    <x-dynamic-component :component="$leftIcon" />
                @else
                    {{ $iconLeft }}
                @endif
            </span>
        @endif

        {{ $slot }}

        @if ($iconRight ?? $rightIcon ?? false)
            <span class="link__icon link__icon--right ml-1.5" aria-hidden="true">
                @if ($rightIcon)
                    <x-dynamic-component :component="$rightIcon" />
                @else
                    {{ $iconRight }}
                @endif
            </span>
        @endif
    </span>

    @includeWhen($showExternalIndicator(), 'blade::components.navigation.partials.external-indicator')
</a>
