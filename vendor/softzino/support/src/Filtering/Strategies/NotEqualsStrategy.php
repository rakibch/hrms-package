<?php

declare(strict_types=1);

namespace Softzino\Support\Filtering\Strategies;

use Illuminate\Database\Eloquent\Builder;
use Softzino\Support\Contracts\FilterStrategyContract;

/**
 * Strategy for applying a 'not equals' filter.
 */
class NotEqualsStrategy implements FilterStrategyContract
{
    /**
     * Apply the 'not equals' filter strategy.
     *
     * @param Builder $builder
     * @param string $column
     * @param mixed $value
     * @return Builder
     */
    public function apply(Builder $builder, string $column, mixed $value): Builder
    {
        return $builder->where($column, '!=', $value);
    }
}