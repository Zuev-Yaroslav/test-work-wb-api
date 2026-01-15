<?php

namespace App\Console\Commands\Store;

use App\Models\Account;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;

class StoreAccountCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:account {--name=} {--api_token_id=} {--company_id=}';
    //php artisan store:account --name= --api_token_id= --company_id=

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$arguments, $options] = $this->validate(optionRules: [
            'name' => 'required|string|unique:api_services',
            'api_token_id' => 'required|string|unique:accounts|exists:api_tokens,id',
            'company_id' => 'required|string|exists:companies,id',
        ]);

        $account = Account::create($options);
        $this->info('Data was saved');
        dump($account->toArray());
    }
}
