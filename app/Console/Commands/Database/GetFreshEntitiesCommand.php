<?php

namespace App\Console\Commands\Database;

use App\Exceptions\ModelExistsException;
use App\Models\ApiToken;
use App\Models\Income;
use App\Models\Order;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class GetFreshEntitiesCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:get-fresh-entities {model} {page} {token}';
    // php artisan database:get-fresh-entities {model} {page} {token}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get fresh entities';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$arguments, $options] = $this->validate(argumentRules: [
            'token' => 'required|string',
            'page' => 'required|integer|min:1',
        ]);
        $model = strtolower($this->argument('model'));
        ModelExistsException::checkExistsModel($model);
        $relationName = Str::plural($model);

        $apiToken = ApiToken::where('token', $this->argument('token'))->first();
        if (!$apiToken) {
            $this->error('Invalid token');
            return;
        }
        $entities = $apiToken
            ->$relationName()
            ->freshFilter()
            ->latestDate()
            ->paginate(perPage: 5, page: $this->argument('page'));
        dump($entities->toArray());
    }
}
