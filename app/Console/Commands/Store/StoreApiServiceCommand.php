<?php

namespace App\Console\Commands\Store;

use App\Models\ApiService;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;

class StoreApiServiceCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:api-service {--name=}';
    // php artisan store:api-service {--name=}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Api Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$arguments, $options] = $this->validate(optionRules: [
            'name' => 'required|string|unique:api_services',
        ]);

        $apiService = ApiService::create($options);
        $this->info('Data was saved');
        dump($apiService->toArray());
    }
}
