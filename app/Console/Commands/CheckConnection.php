<?php

namespace App\Console\Commands;

use App\Models\ConnectionTest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

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
        $connection = ConnectionTest::create();

        exec('ping -c 1 ' . config('connection.host'), $output, $code);

        if($code !== 0) {
            $output[] = '';
            $output[] = 'Begin traceroute...';
            try {
                exec('traceroute ' . config('connection.host'), $trace_output);
                $output = array_merge($output, $trace_output);
            } catch (\Exception $e) {
                $output[] = 'Could not run traceroute.';
            }
        }

        $connection->update([
            'output' => implode(PHP_EOL, $output),
            'return_code' => $code,
            'up' => $code === 0,
            'completed_at' => Carbon::now(),
        ]);
        return 0;
    }
}
