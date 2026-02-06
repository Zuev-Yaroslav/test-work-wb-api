<?php

namespace App\Console\Commands\PullFromApi;

use Illuminate\Console\Command;

class PullFromApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull-from-api';

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
        $this->call(PullEntityFromApiCommand::class, ['income']);
        $this->call(PullEntityFromApiCommand::class, ['order']);
        $this->call(PullEntityFromApiCommand::class, ['sale']);
        $this->call(PullEntityFromApiCommand::class, ['stock']);
    }
}
