<?php

declare(strict_types=1);

namespace Rawilk\Blade\Concerns;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

/**
 * This trait helps facilitate passing an array of unknown attributes to a component
 * since there isn't a good way to do this when rendering a blade component (that I know of).
 */
trait HasExtraAttributes
{
    public ?HtmlString $extraAttributes = null;

    public function setExtraAttributes(null|array|Collection $attributes): void
    {
        if (is_null($attributes)) {
            return;
        }

        $attributes = collect($attributes)
            ->filter()
            ->map(fn ($value, $key) => "{$key}=\"{$value}\"")
            ->toArray();

        $this->extraAttributes = new HtmlString(implode(PHP_EOL, $attributes));
    }
}
