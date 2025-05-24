<?php

declare(strict_types=1);

namespace Softzino\Support\Contracts;

use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TQuery of \Illuminate\Database\Eloquent\Builder<TModel>
 * Interface for filter strategies.
 */
interface FilterStrategyContract
{
    /**
     * Apply the filter strategy to the query builder.
     *
     * @param TQuery $builder The query builder instance.
     * @param string $column The column to filter on.
     * @param mixed $value The value to filter by.
     * @return TQuery The modified query builder instance.
     */
    public function apply(Builder $builder, string $column, mixed $value);
}