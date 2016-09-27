<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class WebsocketStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $command = "ps axf | grep \"php app/Core/websocket.php$\" | grep -v grep | awk '{print $1}'";
        $process = new Process($command);
        $process->run();

        if ($process->isSuccessful()) {
            $status = $process->getOutput() ? 'ON' : 'OFF';
            echo "Websocket status: " . $status . "\n";
        }
    }
}
