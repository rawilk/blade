<?php

declare(strict_types=1);

namespace Rawilk\Blade\Enums;

enum CardType: string
{
    case Error = 'error';
    case Success = 'success';
}
