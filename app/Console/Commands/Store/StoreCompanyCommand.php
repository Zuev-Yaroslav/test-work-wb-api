<?php

namespace App\Console\Commands\Store;

use App\Models\Company;
use App\Traits\ValidatesInputs;
use Illuminate\Console\Command;

class StoreCompanyCommand extends Command
{
    use ValidatesInputs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:company {--name=}';
    // php artisan store:company {--name=}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create company';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        [$arguments, $options] = $this->validate(optionRules: [
           'name' => 'required|string|unique:companies',
        ]);

        $company = Company::create($options);
        $this->info('Data was saved');
        dump($company->toArray());

    }
}
