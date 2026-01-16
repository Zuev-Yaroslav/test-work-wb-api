<?php

namespace App\HttpClients;

use App\Models\Order;

class OrderHttpClient extends  HttpClient
{
    protected const ENDPOINT_INDEX = '/orders';
    protected const MODEL_CLASS = Order::class;
}
