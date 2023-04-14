<?php

namespace Halimzidoune\LaravelPostmanApi\Commands;

use Illuminate\Console\Command;

class LaravelPostmanApiCommand extends Command
{
    public $signature = 'laravel-postman-api';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
