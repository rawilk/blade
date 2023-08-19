<div {{ $attributes->class('lg:flex lg:gap-x-16') }}>
    <aside class="inner-nav">
        <nav class="flex-none">
            <ul role="list" class="flex gap-x-3 gap-y-1 whitespace-nowrap lg:flex-col">
                {{ $nav }}
            </ul>
        </nav>
    </aside>

    <div class="inner-nav-content">
        {{ $slot }}
    </div>
</div>
