<?php

declare(strict_types=1);

beforeEach(function () {
    config([
        'app.url' => 'https://acme.test',
    ]);
});

it('can determine if a url is external', function (string $href, bool $shouldBeExternal) {
    expect(isExternalLink($href))->toBe($shouldBeExternal);
})->with([
    ['#', false],
    ['/', false],
    ['https://acme.test', false],
    ['https://acme.test/foo', false],
    ['https://google.com', true],
    ['google.com', true],
    ['/foo', false],
]);
