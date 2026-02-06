<?php

use App\Console\Commands\PullFromApi\PullEntityFromApiCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(PullEntityFromApiCommand::class, ['income', Carbon::now()->format('Y-m-d')])->twiceDaily(12, 18);
Schedule::command(PullEntityFromApiCommand::class, ['order', Carbon::now()->format('Y-m-d')])->twiceDaily(12, 18);
Schedule::command(PullEntityFromApiCommand::class, ['sale', Carbon::now()->format('Y-m-d')])->twiceDaily(12, 18);
Schedule::command(PullEntityFromApiCommand::class, ['stock'])->twiceDaily(12, 18);
