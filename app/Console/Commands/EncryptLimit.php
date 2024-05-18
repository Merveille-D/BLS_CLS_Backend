<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class EncryptLimit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bls:encrypt {value} {--limit=32}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $value = $this->argument('value');
        $encrypted = encrypt($value);
        $this->info($encrypted);
    }
}
