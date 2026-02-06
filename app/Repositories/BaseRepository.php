<?php

namespace App\Repositories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository
{
    protected const MODEL_CLASS = Model::class;
    private static array $instances = [];

    private static function getInstance(): self
    {
        if (!isset(self::$instances[static::class])) {
            self::$instances[static::class] = new static();
        }
        return self::$instances[static::class];
    }

    public static function make(): self
    {
        return static::getInstance();
    }

    public function persist(Collection $data, Collection $accountIds, int $page): bool
    {
        if (!isset($data['data'])) {
            dump('No data. There must have been some mistake');
            return false;
        }
        $items = collect($data['data']);
        if ($items->isEmpty()) {
            dump('No data in ' . $page . ' page');
            return false;
        }
        $items->each(function (array $newItem) use ($accountIds) {
            $searchItem = collect($newItem)->only(static::MODEL_CLASS::UNIQUE_ATTRIBUTES);
            $modelObject = static::MODEL_CLASS::updateOrCreate($searchItem->toArray(), $newItem);
            if ($modelObject->wasRecentlyCreated && $accountIds->isNotEmpty()) {
                $modelObject->update(['account_id' => $accountIds->random()]);
            }
        });
        dump(static::MODEL_CLASS . ' records in page ' . $page . ' was saved successfully');

        return true;
    }

}
