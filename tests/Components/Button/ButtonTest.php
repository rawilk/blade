<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade as LaravelBlade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

beforeEach(function () {
    config([
        'blade.defaults.button' => [
            'color' => 'slate',
            'variant' => 'contained',
            'ripple' => true,
            'ripple_focus' => true,
            'show_loader' => null,
            'pill' => false,
            'size' => 'md',
        ],
    ]);
});

it('renders a button', function () {
    $template = '<x-blade::button.button>Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->is('button');

            $button->has('text', 'Click me')
                ->has('class', 'button')
                ->has('class', 'button--slate')
                ->has('class', 'button-contained')
                ->has('class', 'button--md')
                ->has('type', 'button')
                ->has('x-ripple', '')
                ->has('x-ripple-focus', '');

            // By default, the loader element should not be shown if no wire:click is present.
            $button->doesntContain('.button__loader');

            // Buttons should have all content inside a span with a class of 'button__content'.
            $button->contains('.button__content', [
                'text' => 'Click me',
            ]);

            // Content element should not contain icon wrappers by default.
            $content = $button->find('.button__content');
            $content->doesntContain('.button__icon');
        });
});

test('custom classes can be added', function () {
    $template = '<x-blade::button.button class="foo bar">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('class', 'button')
                ->has('class', 'foo')
                ->has('class', 'bar');
        });
});

test('buttons can be rendered as links', function () {
    $template = '<div><x-blade::button.button href="/foo">Click me</x-blade::button.button></div>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->is('a');

            $a->has('text', 'Click me')
                ->has('href', '/foo')
                ->has('class', 'button')
                ->has('class', 'button--slate')
                ->has('class', 'button-contained')
                ->has('class', 'button--md')
                ->has('x-ripple', '')
                ->has('x-ripple-focus', '');

            // Buttons should have all content inside a span with a class of 'button__content'.
            $a->contains('.button__content', [
                'text' => 'Click me',
            ]);
        })
        ->assertElementExists('div', function (AssertElement $div) {
            // Make sure the button does not have a type attribute.
            $div->doesntContain('a', [
                'type' => 'button',
            ]);
        });
});

it('renders a loading indicator when wire:click is present on the button', function () {
    $template = '<x-blade::button.button wire:click="foo">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->is('button');

            $button->has('text', 'Click me')
                ->has('wire:click', 'foo');

            // The button component should automatically add wire:target attributes that correspond to the wire:click attribute.
            $button->has('wire:target', 'foo')
                ->has('wire:loading.attr', 'disabled')
                ->has('wire:loading.class', 'button--busy');

            // By default, the loader element should be rendered if wire:click is present.
            $button->contains('.button__loader', [
                'wire:target' => 'foo',
                'wire:loading.class.delay' => 'opacity-100',
                'wire:loading.class.remove.delay' => 'opacity-0',
            ]);

            // Our button content should get wire:loading attributes to automatically hide the content when the button is busy.
            $button->contains('.button__content', [
                'wire:loading.class.delay' => 'invisible',
                'wire:target' => 'foo',
            ]);
        });
});

test('loading indicator can be disabled even if a wire:click is present on the button', function () {
    $template = '<x-blade::button.button :show-loader="false" wire:click="foo">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->is('button');

            $button->has('text', 'Click me')
                ->has('wire:click', 'foo');

            // The button component should automatically add wire:target attributes that correspond to the wire:click attribute
            // even if we disable the loading indicator.
            $button->has('wire:target', 'foo')
                ->has('wire:loading.attr', 'disabled')
                ->has('wire:loading.class', 'button--busy');

            // The loading indicator markup should not be present in the button.
            $button->doesntContain('.button__loader');

            // Our button content should not get wire:loading attributes without the loading indicator present.
            $button->doesntContain('.button__content', [
                'wire:loading.class.delay' => 'invisible',
                'wire:target' => 'foo',
            ]);
        });
});

test('buttons rendered as links do not get a loading indicator', function () {
    $template = '<div><x-blade::button.button wire:click="foo" href="/foo">Click me</x-blade::button.button></div>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->is('a');

            $a->has('text', 'Click me')
                ->has('href', '/foo')
                ->has('wire:click', 'foo');

            // The loading indicator markup should not be present in the button.
            $a->doesntContain('.button__loader');

            // Our button content should not get wire:loading attributes without the loading indicator present.
            $a->doesntContain('.button__content', [
                'wire:loading.class.delay' => 'invisible',
                'wire:target' => 'foo',
            ]);
        })
        ->assertElementExists('div', function (AssertElement $div) {
            // Make sure the button wire:target attributes
            $div->doesntContain('a', [
                'wire:target' => 'foo',
            ]);
        });
});

test('loading indicator can be rendered on buttons without a wire:click present', function () {
    $template = '<x-blade::button.button :show-loader="true">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->is('button');

            $button->has('text', 'Click me');

            // The loading indicator markup should be present in the button.
            $button->contains('.button__loader');
            $button->doesntContain('.button__loader', [
                'wire:loading.class.delay' => 'opacity-100',
            ]);

            $button->contains('.button__content')
                ->doesntContain('.button__content', [
                    'wire:loading.class.delay' => 'invisible',
                ]);
        });
});

test('button type can be customized', function () {
    $template = '<x-blade::button.button type="submit">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('text', 'Click me')
                ->has('type', 'submit');
        });
});

test('disabled buttons get a negative tabindex applied to them', function () {
    $template = '<x-blade::button.button disabled>Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('disabled')
                ->has('tabindex', '-1');
        });
});

test('ripple directives can be customized on buttons', function () {
    $template = '<x-blade::button.button ripple="color.red.radius.400" ripple-focus="color.blue">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('x-ripple.color.red.radius.400')
                ->has('x-ripple-focus.color.blue');
        });
});

test('ripple directives can be omitted', function () {
    $template = '<div><x-blade::button.button :ripple="false" :ripple-focus="false">Click me</x-blade::button.button></div>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->doesntContain('button', [
                'x-ripple',
                'x-ripple-focus',
            ])
                ->contains('button', [
                    'text' => 'Click me',
                ]);
        });
});

it('can render icons before or after the button content', function () {
    $template = <<<'HTML'
    <x-blade::button.button>
        <x-slot:icon-left>
            left icon
        </x-slot:icon-left>

        Click me

        <x-slot:icon-right>
            right icon
        </x-slot:icon-right>
    </x-blade::button.button>
    HTML;

    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $content = $button->find('.button__content');

            $content->contains('.button__icon--left', [
                'text' => 'left icon',
                'aria-hidden' => 'true',
            ]);

            $content->contains('.button__icon--right', [
                'text' => 'right icon',
                'aria-hidden' => 'true',
            ]);
        })
        ->assertSeeInOrder([
            '<span',
            'left icon',
            '</span>',
            'Click me',
            '<span',
            'right icon',
            '</span>',
        ], false);
});

test('icons can be rendered by name via prop too', function () {
    // Use "right-icon" prop for icon on the right side of the text.
    $template = '<x-blade::button.button left-icon="heroicon-o-trash">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $leftIcon = $button->find('.button__icon--left');
            $leftIcon->contains('svg');

            $button->doesntContain('.button__icon--right');
        });
});

test('disabled button links get a pointer-events-none to prevent clicking', function () {
    $template = '<x-blade::button.button href="/foo" disabled>Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->has('href', '/foo')
                ->has('disabled')
                ->has('class', 'pointer-events-none');
        });
});

test('different variants of buttons can be used', function (string $variant, string $expectedClass) {
    $template = "<x-blade::button.button variant=\"{$variant}\">Click me</x-blade::button.button>";
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) use ($expectedClass) {
            $button->has('class', $expectedClass);
        });
})->with([
    'contained' => ['contained', 'button-contained'],
    'outlined' => ['outlined', 'button-outlined'],
    'text' => ['text', 'button-text'],
]);

test('buttons can be rendered as a "pill"', function () {
    $template = '<x-blade::button.button pill>Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('class', 'button--pill');
        });
});

test('buttons can be rendered as different sizes', function (string $size) {
    $template = "<x-blade::button.button size=\"{$size}\">Click me</x-blade::button.button>";
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) use ($size) {
            $button->has('class', "button--{$size}");
        });
})->with([
    'xs',
    'sm',
    'md',
    'lg',
    'xl',
]);

test('buttons can be full width', function () {
    $template = '<x-blade::button.button block>Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('class', 'button--block')
                ->has('class', 'w-full');
        });
});

test('custom colors can be used for buttons', function () {
    $template = '<x-blade::button.button color="red">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('class', 'button--red');
        });
});

test('config defaults can be overridden', function () {
    config()->set('blade.defaults.button.color', 'blue');
    config()->set('blade.defaults.button.pill', true);
    config()->set('blade.defaults.button.show_loader', false);
    config()->set('blade.defaults.button.variant', 'outlined');

    $template = '<x-blade::button.button wire:click="foo">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('class', 'button--blue')
                ->has('class', 'button--pill')
                ->has('class', 'button-outlined')
                ->has('wire:target', 'foo')
                ->has('wire:loading.attr', 'disabled')
                ->has('wire:loading.class', 'button--busy');

            $button->doesntContain('.button__loader');

            $button->contains('.button__content', [
                'text' => 'Click me',
            ]);

            $button->doesntContain('.button__content', [
                'wire:target' => 'foo',
            ]);
        });
});

test('a different wire:target may be specified from wire:click', function () {
    $template = '<x-blade::button.button wire:click="foo" wire:target="bar">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('wire:target', 'bar')
                ->has('wire:click', 'foo');

            // The loading indicator should use the same wire:target as what was explicitly passed in.
            $button->contains('.button__loader', [
                'wire:target' => 'bar',
            ]);

            // The button content should use the same wire:target as what was explicitly passed in.
            $button->contains('.button__content', [
                'wire:target' => 'bar',
            ]);
        });
});

test('an array of attributes can be passed to a button', function () {
    $extraAttributes = [
        'data-foo' => 'bar',
        'aria-controls' => 'foo',
        'aria-haspopup' => 'true',
        'x-bind:aria-expanded' => 'JSON.stringify(open)',
    ];

    $template = '<x-blade::button.button :extra-attributes="$extraAttributes">Click me</x-blade::button.button>';
    Route::get('/test', fn () => LaravelBlade::render($template, ['extraAttributes' => $extraAttributes]));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) use ($extraAttributes) {
            foreach ($extraAttributes as $attribute => $value) {
                $button->has($attribute, $value);
            }
        });
});
