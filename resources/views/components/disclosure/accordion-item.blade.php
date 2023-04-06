@aware([
    'isFlush' => null,
    'useRegionRole' => true,
])

<div
    x-data
    {{ $attributes->only('class')->class($classes(['flush' => $isFlush])) }}
>
    <div
        x-accordion
        {{ $attributes->except(['class', 'x-data', 'x-collapse']) }}
        x-bind:class="{ 'collapsed': ! $accordion.isOpen, 'expanded': $accordion.isOpen }"
    >
        @include('blade::components.disclosure.partials.accordion-title')

        <div class="accordion-panel"
             @if ($renderRegionRole($useRegionRole)) role="region" @endif
             x-bind:class="{ 'collapsed': ! $accordion.isOpen, 'expanded': $accordion.isOpen }"
             x-accordion:panel
             @if ($xCollapse) x-collapse @endif
        >
            <div class="p-5">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
