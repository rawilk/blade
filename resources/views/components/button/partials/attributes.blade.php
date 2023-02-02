@if ($ripple)
    {{ is_bool($ripple) ? 'x-ripple' : "x-ripple.{$ripple}" }}
@endif
@if ($rippleFocus)
    {{ is_bool($rippleFocus) ? 'x-ripple-focus' : "x-ripple-focus.{$rippleFocus}" }}
@endif
@if ($isDisabled())
    tabindex="-1"
@endif
{{ $extraAttributes ?? '' }}
