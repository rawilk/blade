<div {{ $attributes->class($cardClass()) }}>
    @if ($href)
        <a href="{{ $href }}" class="card-link static">
            <span class="absolute -inset-x-0 -inset-y-0 z-20"></span>
        </a>
    @endif

    <div class="card-img">
        @isset ($img)
            {{ $img }}
        @else
            <img src="{{ $src }}" alt="{{ $alt }}" />
        @endisset
    </div>

    <div @class([
        'card-body',
        'flush' => $flush,
        config('blade.defaults.card.body_class'),
        $bodyClass,
    ])>
        {{ $slot }}
    </div>
</div>
