<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Blade as LaravelBlade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Str;
use Sinnbeck\DomAssertions\Asserts\AssertElement;

use function Pest\Laravel\get;

it('renders a script tag', function () {
    $template = <<<'HTML'
    <x-blade::tags.script>
        console.log('Hello world!');
    </x-blade::tags.script>
    HTML;

    Route::get('/test', fn () => LaravelBlade::render($template));

    get('/test')
        ->assertSee('console.log(\'Hello world!\');', false)
        ->assertElementExists('script', function (AssertElement $script) {
            $script->is('script');
        });
});

it('renders attributes onto the script tag', function () {
    Route::get('/test', fn () => LaravelBlade::render('<x-blade::tags.script src="https://example.com" />'));

    get('/test')
        ->assertElementExists('script', function (AssertElement $script) {
            $script->has('src', 'https://example.com');
        });
});

it('accepts a nonce', function () {
    $nonce = Str::random(32);
    Route::get('/test', fn () => LaravelBlade::render("<x-blade::tags.script nonce=\"{$nonce}\" />"));

    get('/test')
        ->assertElementExists('script', function (AssertElement $script) use ($nonce) {
            $script->has('nonce', $nonce);
        });
});

it('renders a nonce automatically if one is set in Vite', function () {
    Vite::useCspNonce();

    $nonce = Vite::cspNonce();

    Route::get('/test', fn () => LaravelBlade::render('<x-blade::tags.script />'));

    get('/test')
        ->assertElementExists('script', function (AssertElement $script) use ($nonce) {
            $script->has('nonce', $nonce);
        });
})->skip(! class_exists(Vite::class), 'Vite is not installed.');

it('renders a nonce automatically if one is set in spatie/laravel-csp', function () {
    function csp_nonce(): string
    {
        return 'my_nonce';
    }

    Route::get('/test', fn () => LaravelBlade::render('<x-blade::tags.script />'));

    get('/test')
        ->assertElementExists('script', function (AssertElement $script) {
            $script->has('nonce', 'my_nonce');
        });
})->depends('it renders a nonce automatically if one is set in Vite');
