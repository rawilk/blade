@aware([
    'collapse' => false,
])

<div @class([
    'flex',
    '-ml-4 -mt-4 flex-wrap items-center justify-between sm:flex-nowrap' => $wrap && ! $collapse,
    'space-x-3' => ! $wrap || $collapse,
])>
    <div @class([
        'ml-4 mt-4' => $wrap && ! $collapse,
        'min-w-0 flex-1 self-center' => ! $wrap || $collapse,
    ])>
        @if ($title)
            <h3 {{ $componentSlot($title)->attributes }}>{{ $title }}</h3>
        @endif

        @if ($subtitle)
            <p {{ $componentSlot($subtitle)->attributes->class('card-subtitle') }}>{{ $subtitle }}</p>
        @endif
    </div>

    @if ($collapse || $slot->isNotEmpty())
        <div @class([
            'flex-shrink-0',
            'ml-4 mt-4' => $wrap && ! $collapse,
            'flex self-center' => ! $wrap || $collapse,
        ])>
            {{ $slot }}

            @if ($collapse)
                <div class="ml-3 first:ml-0 relative">
                    <button
                        x-accordion:button
                        class="card__action"
                        @if ($shouldRipple($collapse)) x-ripple @endif
                        x-bind:disabled="$accordion.isDisabled"
                    >
                        <x-dynamic-component
                            :component="$getCollapseIcon($collapse)"
                            x-bind:class="{ 'rotate-180': ! $accordion.isOpen }"
                        />
                    </button>
                </div>
            @endif
        </div>
    @endif
</div>
