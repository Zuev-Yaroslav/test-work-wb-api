<?php

namespace App\Console\Commands\Store;

use App\Models\ApiService;
use App\Models\TokenType;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;

class TokenTypeAttachToApiServiceCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attach:token-type-to-api-service';
    //не используется
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Token type attach to Api Service';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tokenTypes = TokenType::all();
        $apiServices = ApiService::all();
        dump('Api services', $apiServices->pluck('id', 'name')->toArray());
        $apiServiceId = $this->choice(
            'Choose id api service', $apiServices->pluck('id')->toArray(),
        );
        dump('Token types', $tokenTypes->pluck('id', 'name')->toArray());
        $tokenTypeId = $this->choice(
            'Choose id token type', $tokenTypes->pluck('id')->toArray(),
        );

        $apiService = $apiServices->find($apiServiceId);
        $apiService->tokenTypes()->attach($tokenTypeId);
        dump('saved');

        dump($apiService->tokenTypes->toArray());
    }
}
