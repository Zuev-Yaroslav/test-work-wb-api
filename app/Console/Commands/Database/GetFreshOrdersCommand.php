<?php

namespace App\Console\Commands\Database;

use App\Models\ApiToken;
use App\Models\Order;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GetFreshOrdersCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:get-fresh-orders {page} {token}';
    // php artisan database:get-fresh-orders {page} {token}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$arguments, $options] = $this->validate(argumentRules: [
            'token' => 'required|string',
            'page' => 'required|integer|min:1',
        ]);

        $apiToken = ApiToken::where('token', $this->argument('token'))->first();
        if (!$apiToken) {
            $this->error('Invalid token');
            return;
        }
        $orders = $apiToken->orders()->freshFilter()->latestDate()->paginate(perPage: 5, page: $this->argument('page'));
        dump($orders->toArray());
    }
}
