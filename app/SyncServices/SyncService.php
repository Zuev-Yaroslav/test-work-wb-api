<?php

namespace App\SyncServices;

use App\HttpClients\HttpClient;
use App\Models\Account;
use App\Repositories\BaseRepository;
use Illuminate\Support\Collection;

class SyncService
{
    public function __construct(
        private HttpClient $httpClient,
        private BaseRepository $repository,
    )
    {}

    public function run(array $queryParams): void
    {
        $accountIds = Account::all()->pluck('id');
        for ($i = 1; true; $i++) {
            $queryParams['page'] = $i;
            $data = $this->httpClient->index($queryParams);
            if (!$this->repository->persist($data, $accountIds, $i)) {
                break;
            }
        }
    }
}
