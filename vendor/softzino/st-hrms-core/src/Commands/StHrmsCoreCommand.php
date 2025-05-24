<?php

namespace Softzino\StHrmsCore\Commands;

use Illuminate\Console\Command;

class StHrmsCoreCommand extends Command
{
    public $signature = 'st-hrms-core';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
