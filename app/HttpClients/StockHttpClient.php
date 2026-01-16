<?php

namespace App\HttpClients;

use App\Models\Stock;

class StockHttpClient extends  HttpClient
{
    protected const ENDPOINT_INDEX = '/stocks';
    protected const MODEL_CLASS = Stock::class;
}
