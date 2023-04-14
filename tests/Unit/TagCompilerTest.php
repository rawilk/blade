<?php

declare(strict_types=1);

use Rawilk\Blade\Support\BladeTagCompiler;

beforeEach(function () {
    $this->compiler = new BladeTagCompiler;
});

it('compiles the scripts tag', function (string $tag) {
    $result = $this->compiler->compile($tag);

    expect('@bladeScripts')->toBe($result);
})->with([
    '<blade:scripts />',
    '<blade:javaScript />',
]);
