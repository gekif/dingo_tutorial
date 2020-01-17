<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run phpunit test';

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
        $timeLimit = 320;

        set_time_limit($timeLimit);

        $process = new Process(
            'vendor' . DIRECTORY_SEPARATOR .
            'bin' . DIRECTORY_SEPARATOR . 'phpunit -c phpunit.xml');

        $process->setWorkingDirectory(base_path());

        $process->setTimeout($timeLimit);

        return $process->run(function ($type, $buffer) {
            echo $buffer;
        });
    }
}
