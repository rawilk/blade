<a href="{{ $href }}"
   {{ $attributes->class($buttonClass()) }}
   @if ($isExternalLink()) rel="{{ $rel($attributes->get('rel')) }}" @endif
   @include('blade::components.button.partials.attributes')
>
    @include('blade::components.button.partials.content')
</a>
