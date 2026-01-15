<?php

namespace App\Console\Commands\Database\Destroy;

use App\Models\Order;
use App\Models\Stock;
use Illuminate\Console\Command;

class DestroyStockCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destroy:destroy-stock {id} {token}';
    //php artisan destroy:destroy-stock {id} {token}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy stock';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $stock = Stock::findOrFail($this->argument('id'));
        if (!$stock->isOwner($this->argument('token'))) {
            $this->error("This stock cannot be deleted");
            return;
        }
        $stock->delete();
        $this->info("This stock deleted");
    }
}
