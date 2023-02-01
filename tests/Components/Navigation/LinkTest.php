<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade as LaravelBlade;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\get;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

beforeEach(function () {
    config([
        'blade.defaults.link' => [
            'app_link' => true,
            'dark' => false,
            'hide_external_indicator' => false,
        ],
        'app.url' => 'https://acme.test',
    ]);
});

it('renders a link', function () {
    $template = '<x-blade::navigation.link href="/foo">Hello world</x-blade::navigation.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->is('a');

            $a->has('text', 'Hello world')
                ->has('href', '/foo')
                ->has('class', 'app-link');

            // Icon wrappers should not be present by default.
            $a->doesntContain('.link__icon');
        });
});

test('custom classes can be added', function () {
    $template = '<x-blade::navigation.link class="foo bar">Hello world</x-blade::navigation.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->has('class', 'app-link')
                ->has('class', 'foo')
                ->has('class', 'bar');
        });
});

test('plain links can be rendered with global config', function () {
    config([
        'blade.defaults.link' => [
            'app_link' => false,
        ],
    ]);

    $template = '<div><x-blade::navigation.link>Hello world</x-blade::navigation.link></div>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('div', function (AssertElement $div) {
            $div->doesntContain('a', [
                'class' => 'app-link',
            ])
            ->contains('a', [
                'text' => 'Hello world',
            ]);
        });
});

test('dark links can be rendered via prop', function () {
    $template = '<x-blade::navigation.link dark>Hello world</x-blade::navigation.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->has('class', 'app-link')
                ->has('class', 'app-link--dark');
        });
});

test('dark links can be rendered via global config', function () {
    config([
        'blade.defaults.link' => [
            'dark' => true,
        ],
    ]);

    $template = '<x-blade::navigation.link>Hello world</x-blade::navigation.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->has('class', 'app-link')
                ->has('class', 'app-link--dark');
        });
});

test('external links receive a rel attribute', function () {
    $template = '<x-blade::navigation.link href="https://google.com">Hello world</x-blade::navigation.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->has('rel');
        });
});

test('an external indicator can be rendered for external links', function () {
    $template = '<x-blade::navigation.link href="https://google.com">Hello world</x-blade::navigation.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->contains('span', [
                'class' => 'external-indicator',
            ]);
        });
});

test('an external indicator icon can be omitted for external links', function () {
    $template = '<x-blade::navigation.link href="https://google.com" hide-external-indicator>Hello world</x-blade::navigation.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->doesntContain('span', [
                'class' => 'external-indicator',
            ]);
        });
});

test('icons can be rendered on either side of the link text', function () {
    $template = <<<'HTML'
    <x-blade::navigation.link href="/foo">
        <x-slot:icon-left>
            left icon
        </x-slot:icon-left>

        Hello world

        <x-slot:icon-right>
            right icon
        </x-slot:icon-right>
    </x-blade::navigation.link>
    HTML;

    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $a->contains('span', [
                'class' => 'link__icon--left',
                'text' => 'left icon',
                'aria-hidden' => 'true',
            ])
            ->contains('span', [
                'class' => 'link__icon--right',
                'text' => 'right icon',
                'aria-hidden' => 'true',
            ]);
        })
        ->assertSeeInOrder([
            '<span',
            'left icon',
            '</span>',
            'Hello world',
            '<span',
            'right icon',
            '</span>',
        ], false);
});

test('icons can be rendered via named props instead', function () {
    $template = '<x-blade::navigation.link href="/foo" left-icon="heroicon-m-pencil">Hello world</x-blade::navigation.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('a', function (AssertElement $a) {
            $leftIcon = $a->find('.link__icon--left');
            $leftIcon->contains('svg');
        });
});
