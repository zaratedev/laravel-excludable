<?php

namespace Zaratesystems\LaravelExcludable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait Excludable
{
    /**
     * Excluded the provided elements from the query results.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $excluded
     * @param  string  $column
     */
    public function scopeExclude(Builder $query, $excluded, string $column = 'id')
    {
        if ($excluded instanceof Collection) {
            $excluded = $excluded->pluck($column)->toArray();
        }

        if ($excluded instanceof Model) {
            $excluded = $excluded->getAttribute($column);
        }

        $excluded = Arr::wrap($excluded);

        return empty($excluded) ? $query : $query->whereNotIn($column, $excluded);
    }
}
