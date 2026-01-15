<?php

use App\Console\Commands\PullFromApi\PullIncomeFromApiCommand;
use App\Console\Commands\PullFromApi\PullOrderFromApiCommand;
use App\Console\Commands\PullFromApi\PullSaleFromApiCommand;
use App\Console\Commands\PullFromApi\PullStockFromApiCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(PullIncomeFromApiCommand::class, [Carbon::now()->format('Y-m-d')])->twiceDaily(12, 18);
Schedule::command(PullOrderFromApiCommand::class, [Carbon::now()->format('Y-m-d')])->twiceDaily(12, 18);
Schedule::command(PullSaleFromApiCommand::class, [Carbon::now()->format('Y-m-d')])->twiceDaily(12, 18);
Schedule::command(PullStockFromApiCommand::class)->twiceDaily(12, 18);
