<?php

namespace App\Console\Commands\Store;

use App\Models\TokenType;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;

class StoreTokenTypeCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:token-type {--name=} {--api_service_id=}';
    // php artisan store:token-type {--name=}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create token type';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$arguments, $options] = $this->validate(optionRules: [
            'name' => 'required|string|unique:token_types',
            'api_service_id' => 'required|integer|exists:api_services,id',
        ]);

        $tokenType = TokenType::create($options);
        $this->info('Data was saved');
        dump($tokenType->toArray());
    }
}
