<div x-data>
    <div
        x-accordion:group
        {{ $attributes->class('accordion-group') }}
    >
        {{ $before ?? '' }}

        {{-- wrapped in a div so our :last-of-type, :first-of-type selectors work properly --}}
        <div>
            {{ $slot }}
        </div>

        {{ $after ?? '' }}
    </div>
</div>
