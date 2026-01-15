<?php

namespace App\Console\Commands\Database\Destroy;

use App\Models\Order;
use Illuminate\Console\Command;

class DestroyOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'destroy:destroy-order {id} {token}';
    //php artisan destroy:destroy-order {id} {token}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy order';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $order = Order::findOrFail($this->argument('id'));
        if (!$order->isOwner($this->argument('token'))) {
            $this->error("This order cannot be deleted");
            return;
        }
        $order->delete();
        $this->info("This order deleted");
    }
}
