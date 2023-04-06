<div class="accordion-title">
    <{{ $titleTag }}>
        <button
            x-accordion:button
            @class([
                'accordion-title__button',
                'flush' => $componentIsFlush($isFlush),
                'icon-left' => $iconLeft,
                config('blade.defaults.accordion.title_classes'),
                $titleClasses,
            ])
            x-bind:class="{ 'expanded': $accordion.isOpen, 'collapsed': ! $accordion.isOpen }"
        >
            <span class="flex-1">{{ $title }}</span>

            @if ($icon)
                <x-dynamic-component
                    :component="$icon"
                    @class([
                        'accordion-icon',
                        'can-rotate' => $rotateIcon,
                    ])
                    x-bind:class="{ 'closed': ! $accordion.isOpen }"
                />
            @endif
        </button>
    </{{ $titleTag }}>
</div>
