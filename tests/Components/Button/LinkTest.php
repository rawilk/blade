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
        'blade.defaults.link' => [
            'app_link' => true,
            'dark' => false,
            'hide_external_indicator' => false,
        ],
    ]);
});

it('renders a button styled like a link', function () {
    $template = '<x-blade::button.link>Click me</x-blade::button.link>';
    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertElementExists('button', function (AssertElement $button) {
            $button->is('button');

            $button->has('text', 'Click me')
                ->has('class', 'button--link')
                ->has('class', 'app-link')
                ->has('type', 'button')
                ->has('x-ripple')
                ->contains('.button__content', [
                    'text' => 'Click me',
                ]);

            // By default, the loader element should not be shown if no wire:click is present.
            $button->doesntContain('.button__loader');
        });
});
