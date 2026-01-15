<?php

namespace App\Console\Commands\Store;

use App\Models\ApiService;
use App\Models\ApiToken;
use App\Models\TokenType;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;

class StoreApiTokenCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:api-token {--token=} {--token_type_id=}';
    // php artisan store:api-token {--token=} {--token_type_id=}
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Api Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$arguments, $options] = $this->validate(optionRules: [
            'token' => 'required|string|unique:api_tokens',
            'token_type_id' => 'required|integer|exists:token_types,id',
        ]);

        $apiToken = ApiToken::create($options);
        $this->info('Data was saved');
        dump($apiToken->toArray());
    }
}
