<?php

return [
    'models' => [
        'income' => \App\Models\Income::class,
        'order' => \App\Models\Order::class,
        'sale' => \App\Models\Sale::class,
        'stock' => \App\Models\Stock::class,
    ],
    'http_clients' => [
        'income' => \App\HttpClients\IncomeHttpClient::class,
        'order' => \App\HttpClients\OrderHttpClient::class,
        'sale' => \App\HttpClients\SaleHttpClient::class,
        'stock' => \App\HttpClients\StockHttpClient::class,
    ],
    'repositories' => [
        'income' => \App\Repositories\IncomeRepository::class,
        'order' => \App\Repositories\OrderRepository::class,
        'sale' => \App\Repositories\SaleRepository::class,
        'stock' => \App\Repositories\StockRepository::class,
    ]
];
