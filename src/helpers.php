<?php

declare(strict_types=1);

use Illuminate\Support\Str;

if (! function_exists('isExternalLink')) {
    /**
     * Determine if a given url is an external url (i.e. not the app's url).
     *
     * @param  string|null  $url
     * @return bool
     */
    function isExternalLink(?string $url): bool
    {
        // This is probably a relative link.
        if (Str::startsWith($url, ['#', '/'])) {
            return false;
        }

        $parsed = parse_url($url);
        $parsedSiteUrl = parse_url(config('app.url'));

        return ($parsed['host'] ?? '') !== ($parsedSiteUrl['host'] ?? '');
    }
}
