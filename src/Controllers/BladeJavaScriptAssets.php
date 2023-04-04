<?php

declare(strict_types=1);

namespace Rawilk\Blade\Controllers;

use Rawilk\Blade\Controllers\Concerns\CanPretendToBeAFile;

final class BladeJavaScriptAssets
{
    use CanPretendToBeAFile;

    public function source()
    {
        return $this->pretendResponseIsFile(__DIR__ . '/../../dist/blade.js');
    }

    public function maps()
    {
        return $this->pretendResponseIsFile(__DIR__ . '/../../dist/blade.js.map');
    }
}
