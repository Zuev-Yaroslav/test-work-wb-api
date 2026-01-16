<?php

namespace App\HttpClients;

use App\Models\Income;

class IncomeHttpClient extends  HttpClient
{
    protected const ENDPOINT_INDEX = '/incomes';
    protected const MODEL_CLASS = Income::class;
}
