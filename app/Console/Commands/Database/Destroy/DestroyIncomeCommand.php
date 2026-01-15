<?php

namespace App\Console\Commands\Database\Destroy;

use App\Models\Income;
use App\Models\Order;
use Illuminate\Console\Command;

class DestroyIncomeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destroy:destroy-income {id} {token}';
    //php artisan destroy:destroy-income {id} {token}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy income';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $income = Income::findOrFail($this->argument('id'));
        if (!$income->isOwner($this->argument('token'))) {
            $this->error("This income cannot be deleted");
            return;
        }
        $income->delete();
        $this->info("This income deleted");
    }
}
