<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Rawilk\Blade\Facades\Blade;

it('outputs the script source', function () {
    $this->assertStringContainsString(
        '<script src="/blade/blade.js?',
        Blade::javaScript(),
    );
});

it('outputs a comment when app is in debug mode', function () {
    config()->set('app.debug', true);

    $this->assertStringContainsString(
        '<!-- Blade Scripts -->',
        Blade::javaScript(),
    );
});

it('does not output a comment when not in debug mode', function () {
    config()->set('app.debug', false);

    $this->assertStringNotContainsString(
        '<!-- Blade Scripts -->',
        Blade::javaScript(),
    );
});

it('can use a custom asset url', function () {
    config()->set('blade.asset_url', 'https://example.com');

    $this->assertStringContainsString(
        '<script src="https://example.com/blade/blade.js?',
        Blade::javaScript(),
    );
});

it('accepts an asset url as an argument', function () {
    $this->assertStringContainsString(
        '<script src="https://example.com/blade/blade.js?',
        Blade::javaScript(['asset_url' => 'https://example.com']),
    );
});

it('can output a nonce on the script tag', function () {
    $nonce = Str::random(32);

    $this->assertStringContainsString(
        "nonce=\"{$nonce}\"",
        Blade::javaScript(['nonce' => $nonce]),
    );
});
