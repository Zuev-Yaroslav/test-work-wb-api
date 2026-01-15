<?php

namespace App\Console\Commands\PullFromApi;

use App\HttpClients\StockHttpClient;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PullStockFromApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull-from-api:stock';

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
        $now = Carbon::now()->format('Y-m-d');
        $stockHttpClient = StockHttpClient::make();
        $stockHttpClient->auth(config('wbapi.auth_key'));
        $queryParams = [
            'dateFrom' => $now,
            'dateTo' => $now,
            'limit' => 500,
        ];

        $stockHttpClient->saveToDB($queryParams, Stock::class);
    }
}
