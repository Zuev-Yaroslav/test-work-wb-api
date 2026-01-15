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
        $this->call(PullStockFromApiCommand::class);
        $this->call(PullIncomeFromApiCommand::class);
        $this->call(PullOrderFromApiCommand::class);
        $this->call(PullSaleFromApiCommand::class);
    }
}
