<?php

namespace App\HttpClients;

use App\Models\Account;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

abstract class HttpClient
{
    protected const ENDPOINT_INDEX = '/entity';
    protected PendingRequest $http;
    private static array $instances = [];

    private static function getInstance(): self
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }
        return self::$instances[static::class];
    }

    public static function make(): self
    {
        return static::getInstance();
    }

    public function auth(string $key): self
    {
        $this->http->withQueryParameters(['key' => $key]);
        return $this;
    }

    private function __construct()
    {
        $this->http = Http::wbapi();
    }

    public function index(array $queryParams): Collection
    {
        $response = $this->http->get(static::ENDPOINT_INDEX, $queryParams);
        if ($response->getStatusCode() === 429) {
            dump('Too many requests. Next attempt in 100 seconds.');
            sleep(100);
            $response = $this->http->get(static::ENDPOINT_INDEX, $queryParams);
        }

        return $response->collect();
    }

    public function saveToDB(array $queryParams, string $modelClass): void
    {
        $accountIds = Account::all()->pluck('id');

        for ($i = 1; true; $i++) {
            $queryParams['page'] = $i;
            $data = $this->index($queryParams);
            if (!isset($data['data'])) {
                dump('No data. There must have been some mistake');
                break;
            }
            $items = collect($data['data']);
            if ($items->isEmpty()) {
                dump('No data in ' . $i . ' page');
                break;
            }
            $items->each(function (array $newItem) use ($modelClass, $accountIds) {
                if ($accountIds->isNotEmpty()) {
                    $newItem['account_id'] = $accountIds->random();
                }
                $searchItem = collect($newItem)->only($modelClass::UNIQUE_ATTRIBUTES);
                $modelClass::updateOrCreate($searchItem->toArray(), $newItem);
                // ниже код, который изменяет данные в завимости от last_change_date, но не могу понять нужно ли это
//                $modelObject = $modelClass::firstOrCreate($searchItem->toArray(), $newItem);
//                if (
//                    $newItem['last_change_date'] &&
//                    !$modelObject->wasRecentlyCreated &&
//                    $modelObject->last_change_date < $newItem['last_change_date']
//                ) {
//                    $modelObject->update($newItem);
//                }
            });
            dump($modelClass . ' records in page ' . $i . ' was saved successfully');
        }

    }

}
