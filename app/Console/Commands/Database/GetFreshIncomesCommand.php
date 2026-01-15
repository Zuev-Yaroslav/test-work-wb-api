<?php

namespace App\Console\Commands\Database;

use App\Models\ApiToken;
use App\Models\Income;
use App\Models\Order;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class GetFreshIncomesCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:get-fresh-incomes {page} {token}';
    // php artisan database:get-fresh-incomes {page} {token}

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
        $incomes = $apiToken->incomes()->freshFilter()->latestDate()->paginate(perPage: 5, page: $this->argument('page'));
        dump($incomes->toArray());
    }
}
