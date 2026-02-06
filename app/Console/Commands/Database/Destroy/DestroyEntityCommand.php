<?php

namespace App\Console\Commands\Database\Destroy;

use App\Exceptions\ModelExistsException;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class DestroyEntityCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:destroy-entity {model} {id} {token}';
    //php artisan database:destroy-entity {model} {id} {token}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Destroy entity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var class-string<Model> $modelClass */
        $model = strtolower($this->argument('model'));
        ModelExistsException::checkExistsModel($model);
        $modelClass = config('entities.models.' . $model);
        $entity = $modelClass::findOrFail($this->argument('id'));
        if (!$entity->isOwner($this->argument('token'))) {
            $this->error("This $model cannot be deleted");
            return;
        }
        $entity->delete();
        $this->info("This $model deleted");
    }
}
