<?php

namespace App\Console\Commands;

use App\Models\ConnectionTest;
use Illuminate\Console\Command;

class CheckConnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:connection';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check internet connection';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        exec('mtr -rwc 1 8.8.8.8', $output, $code);
        ConnectionTest::create([
            'output' => $output,
            'return_code' => $code,
            'up' => $code === 0,
        ]);
        return 0;
    }
}
