<div {{ $attributes->except(['style'])->class($cardClass()) }}
     @if ($stickyHeader)
         style="--sticky-header-offset: {{ $stickyHeaderOffset }};"
     @endif
>
    @if ($header)
        <div {{ $componentSlot($header)->attributes->class($headerClass()) }}>
            {{ $header }}
        </div>
    @endif

    <div @class([
        'card-body',
        'flush' => $flush,
        config('blade.defaults.card.body_class'),
        $bodyClass,
    ])>
        @if ($href)
            <a href="{{ $href }}" class="card-link static">
                <span class="absolute -inset-x-0 -inset-y-0 z-20"></span>
            </a>
        @endif

        {{ $slot }}
    </div>

    @if ($footer)
        <div {{ $componentSlot($footer)->attributes->class('card-footer') }}>
            {{ $footer }}
        </div>
    @endif
</div>
