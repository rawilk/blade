<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Tags;

use Illuminate\Support\Facades\Vite;
use Rawilk\Blade\Components\BladeComponent;

/**
 * This component is honestly overkill unless you don't want to deal with
 * setting a nonce manually everytime you need an inline script.
 */
class Script extends BladeComponent
{
    public function __construct(public ?string $nonce = null)
    {
        $this->nonce = $nonce ?? $this->getNonce();
    }

    protected function getNonce(): ?string
    {
        // If there is a csp package installed, i.e. spatie/laravel-csp, we'll try and use that first.
        if (function_exists('csp_nonce')) {
            return csp_nonce();
        }

        // If that failed, we'll try to check for the existence of a nonce from vite.
        if (class_exists(Vite::class)) {
            return Vite::cspNonce();
        }

        return null;
    }
}
