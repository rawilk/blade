<?php

namespace Rawilk\Blade\Commands;

use Illuminate\Console\Command;

class BladeCommand extends Command
{
    public $signature = 'blade';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
