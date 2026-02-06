<?php

namespace App\Console\Commands\PullFromApi;

use App\Exceptions\CheckDateException;
use App\Exceptions\ModelExistsException;
use App\HttpClients\HttpClient;
use App\HttpClients\IncomeHttpClient;
use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use App\Repositories\BaseRepository;
use App\Repositories\IncomeRepository;
use App\SyncServices\SyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PullEntityFromApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull-from-api:entity {model} {from-date?}';

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
        $model = strtolower($this->argument('model'));
        ModelExistsException::checkExistsModel($model);
        $now = Carbon::now()->format('Y-m-d');
        $fromDate = ($model === 'stock') ? $now : $this->argument('from-date');

        /** @var class-string<HttpClient> $httpClientClass */
        /** @var class-string<BaseRepository> $repositoryClass */
        $httpClientClass = config('entities.http_clients.' . $model);
        $repositoryClass = config('entities.repositories.' . $model);
        CheckDateException::checkFormatDate($this->argument('from-date'));

        $httpClient = $httpClientClass::make();
        $httpClient->auth(config('wbapi.auth_key'));

        $queryParams = [
            'dateFrom' => $fromDate ?? '2000-01-01',
            'dateTo' => $now,
            'limit' => 500,
        ];

        $syncService = new SyncService($httpClient, $repositoryClass::make());
        $syncService->run($queryParams);

    }
}
