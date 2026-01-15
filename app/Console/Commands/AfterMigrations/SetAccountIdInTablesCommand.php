<?php

namespace App\Console\Commands\AfterMigrations;

use App\Models\Account;
use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class SetAccountIdInTablesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'after-migrations:set-account-id-in-tables';
    //php artisan after-migrations:set-account-id-in-tables

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set account id in tables';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = ['Stock', 'Income', 'Order', 'Sale'];
        $choice = $this->choice(
            'Choose model.',
            array_merge($models, ['All']),
        );
        $accountIds = Account::all()->pluck('id');
        if ($accountIds->isEmpty()) {
            $this->error('Accounts is not found');
            return;
        }
        if ($choice === 'All') {
            foreach ($models as $modelClass) {
                $this->process($modelClass, $accountIds);
            }
            return;
        }

        $this->process($choice, $accountIds);
    }

    private function setAccountIdInTables($entities, Collection $accountIds) : void
    {
        if ($entities->IsEmpty()) {
            $this->info('Everyone has an account id.');
            return;
        }
        $this->withProgressBar(
            $entities,
            function (Model $entity) use ($accountIds) {
                $entity->update([
                    'account_id' => $accountIds->random(),
                ]);
            }
        );
    }
    private function process(string $modelClass, Collection $accountIds) : void
    {
        $modelFullClass = "App\\Models\\" . $modelClass;
        $this->info("start this $modelClass process");
        $stocks = $modelFullClass::whereNull('account_id')->latestDate()->get();
        $this->setAccountIdInTables($stocks, $accountIds);
        $this->info("\n" . 'Done');
    }
}
