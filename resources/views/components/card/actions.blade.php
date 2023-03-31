<div @class([
    'flex',
    '-ml-4 -mt-4 flex-wrap items-center justify-between sm:flex-nowrap' => $wrap,
    'space-x-3' => ! $wrap,
])>
    <div @class([
        'ml-4 mt-4' => $wrap,
        'min-w-0 flex-1' => ! $wrap,
    ])>
        @if ($title)
            <h3 {{ $componentSlot($title)->attributes }}>{{ $title }}</h3>
        @endif

        @if ($subtitle)
            <p {{ $componentSlot($subtitle)->attributes->class('card-subtitle') }}>{{ $subtitle }}</p>
        @endif
    </div>

    @unless ($slot->isEmpty())
        <div @class([
            'flex-shrink-0',
            'ml-4 mt-4' => $wrap,
            'flex self-center' => ! $wrap,
        ])>
            {{ $slot }}
        </div>
    @endunless
</div>
