<?php

declare(strict_types=1);

namespace Rawilk\Blade\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;
use Orchestra\Testbench\TestCase as Orchestra;
use Rawilk\Blade\BladeServiceProvider;

class TestCase extends Orchestra
{
    use InteractsWithViews;

    protected $enablesPackageDiscoveries = true;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();
    }

    protected function getPackageProviders($app): array
    {
        return [
            BladeServiceProvider::class,
        ];
    }
}
