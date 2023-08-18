<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade as LaravelBlade;
use Illuminate\Support\Facades\Route;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

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

it('renders an icon button', function () {
    $template = <<<'HTML'
    <x-blade::button.icon>
        icon
    </x-blade::button.icon>
    HTML;

    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->is('button');

            $button->has('text', 'icon')
                ->has('class', 'button')
                ->has('class', 'button--icon')
                ->has('class', 'button--slate')
                ->has('class', 'button--md')
                ->has('type', 'button')
                ->has('x-ripple')
                ->has('x-ripple-focus')
                ->contains('.button__content', [
                    'text' => 'icon',
                ]);

            // By default, the loader element should not be shown if no wire:click is present.
            $button->doesntContain('.button__loader');
        });
});

test('an icon prop can be specified for convenience', function () {
    $template = '<x-blade::button.icon icon="heroicon-o-trash" />';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $content = $button->find('.button__content');
            $content->contains('svg');
        });
});

it('can render icon buttons as links', function () {
    $template = '<x-blade::button.icon href="/foo">icon</x-blade::button.icon>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->is('a');

            $a->has('text', 'icon')
                ->has('href', '/foo')
                ->has('class', 'button')
                ->has('class', 'button--icon')
                ->has('class', 'button--slate')
                ->has('class', 'button--md')
                ->has('x-ripple')
                ->has('x-ripple-focus')
                ->contains('.button__content', [
                    'text' => 'icon',
                ]);

            // Loader element should never be rendered on the links.
            $a->doesntContain('.button__loader');
        });
});

it('renders a loading indicator when wire:click is present on the button', function () {
    $template = '<x-blade::button.icon wire:click="foo">icon</x-blade::button.icon>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('wire:click', 'foo')
                ->has('wire:target', 'foo')
                ->has('wire:loading.attr', 'disabled')
                ->has('wire:loading.class', 'button--busy');

            $button->contains('.button__loader', [
                'wire:target' => 'foo',
                'wire:loading.class.delay' => 'opacity-100',
                'wire:loading.class.remove.delay' => 'opacity-0',
            ]);

            $button->contains('.button__content', [
                'text' => 'icon',
                'wire:loading.class.delay' => 'invisible',
                'wire:target' => 'foo',
            ]);
        });
});

test('different variants of the button can be used', function (string $variant, string $expectedClass) {
    $template = "<x-blade::button.icon variant=\"{$variant}\">icon</x-blade::button.icon>";
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

test('config defaults can be overridden', function () {
    config()->set('blade.defaults.button.color', 'red');

    $template = '<x-blade::button.icon>icon</x-blade::button.icon>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->has('class', 'button--red');
        });
});
