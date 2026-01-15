<?php

namespace App\Console\Commands\PullFromApi;

use App\Exceptions\CheckDateException;
use App\HttpClients\SaleHttpClient;
use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PullSaleFromApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull-from-api:sale {from-date?}';

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
        CheckDateException::checkFormatDate($this->argument('from-date'));
        $now = Carbon::now()->format('Y-m-d');
        $saleHttpClient = SaleHttpClient::make();
        $saleHttpClient->auth(config('wbapi.auth_key'));
        $queryParams = [
            'dateFrom' => $this->argument('from-date') ?? '2000-01-01',
            'dateTo' => $now,
            'limit' => 500,
        ];

        $saleHttpClient->saveToDB($queryParams, Sale::class);
    }
}
