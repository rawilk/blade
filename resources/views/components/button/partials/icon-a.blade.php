<a href="{{ $href }}"
   {{ $attributes->class($buttonClass()) }}
    @if ($isExternalLink()) rel="{{ $rel($attributes->get('rel')) }}" @endif
    @include('blade::components.button.partials.attributes')
>
    <span class="button__content">
        @if ($icon)
            <x-dynamic-component :component="$icon" />
        @else
            {{ $slot }}
        @endif
    </span>
</a>
