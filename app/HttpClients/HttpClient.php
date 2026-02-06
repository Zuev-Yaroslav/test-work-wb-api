<?php

namespace App\HttpClients;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

abstract class HttpClient
{
    protected const ENDPOINT_INDEX = '/entity';
    protected const MODEL_CLASS = Model::class;
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

    public function auth(?string $key): self
    {
        $key = ($key) ? : config('wbapi.auth_key');
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

}
