<?php

namespace App\Console\Commands\Database\Destroy;

use App\Models\Order;
use App\Models\Sale;
use Illuminate\Console\Command;

class DestroySaleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destroy:destroy-sale {id} {token}';
    //php artisan destroy:destroy-sale {id} {token}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy sale';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sale = Sale::findOrFail($this->argument('id'));
        if (!$sale->isOwner($this->argument('token'))) {
            $this->error("This sale cannot be deleted");
            return;
        }
        $sale->delete();
        $this->info("This sale deleted");
    }
}
