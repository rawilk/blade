<?php

declare(strict_types=1);

namespace Rawilk\Blade\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @property bool $noReferrer
 * @property bool $hideExternalIndicator
 * @property null|string $href
 */
trait HandlesExternalLinks
{
    // Locally cache the result for "isExternalLink()" so we're not calling it multiple times.
    protected ?bool $_external = null;

    public function isExternalLink(): bool
    {
        if ($this->_external !== null) {
            return $this->_external;
        }

        return $this->_external = isExternalLink($this->href);
    }

    public function rel(?string $userDefinedRel = null): string
    {
        return Arr::toCssClasses([
            'nofollow',
            'noopener',
            'noreferrer' => $this->noReferrer,
            'external',
            Str::replace(['nofollow', 'noreferrer', 'noopener', 'external'], '', (string) $userDefinedRel),
        ]);
    }

    public function showExternalIndicator(): bool
    {
        if ($this->hideExternalIndicator) {
            return false;
        }

        return $this->isExternalLink();
    }
}
