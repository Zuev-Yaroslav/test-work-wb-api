<?php

namespace App\Console\Commands\PullFromApi;

use App\Exceptions\CheckDateException;
use App\HttpClients\IncomeHttpClient;
use App\Models\Income;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PullIncomeFromApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull-from-api:income {from-date?}';

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
        $orderHttpClient = IncomeHttpClient::make();
        $orderHttpClient->auth(config('wbapi.auth_key'));

        $queryParams = [
            'dateFrom' => $this->argument('from-date') ?? '2000-01-01',
            'dateTo' => $now,
            'limit' => 500,
        ];

        $orderHttpClient->saveToDB($queryParams, Income::class);

    }
}
