<?php

declare(strict_types=1);

namespace Rawilk\Blade\Components\Card;

use Illuminate\Support\Arr;
use Rawilk\Blade\Components\BladeComponent;

class Footer extends BladeComponent
{
    public function __construct(public bool $reverse = true, public bool $stacksButtons = false)
    {
    }

    public function classes(): string
    {
        return Arr::toCssClasses([
            'flex items-center',
            'flex-row-reverse justify-start space-x-4 space-x-reverse' => $this->reverse && ! $this->stacksButtons,
            'flex-wrap md:justify-start md:flex-row-reverse md:flex-wrap-none space-x-0 md:space-x-4 md:space-x-reverse space-y-4 md:space-y-0' => $this->reverse && $this->stacksButtons,
            'justify-end space-x-4' => ! $this->reverse && ! $this->stacksButtons,
            'justify-end flex-wrap md:space-x-4 space-y-4 md:space-y-0' => ! $this->reverse && $this->stacksButtons,
        ]);
    }
}
