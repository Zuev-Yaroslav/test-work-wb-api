<?php

namespace App\HttpClients;

use App\Models\Sale;

class SaleHttpClient extends  HttpClient
{
    protected const ENDPOINT_INDEX = '/sales';
    protected const MODEL_CLASS = Sale::class;
}
