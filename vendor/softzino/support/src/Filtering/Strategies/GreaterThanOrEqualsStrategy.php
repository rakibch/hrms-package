<?php

declare(strict_types=1);

namespace Softzino\Support\Filtering\Strategies;

use Illuminate\Database\Eloquent\Builder;
use Softzino\Support\Contracts\FilterStrategyContract;

/**
 * Strategy for applying a 'greater than or equals' filter.
 */
class GreaterThanOrEqualsStrategy implements FilterStrategyContract
{
    /**
     * Apply the 'greater than or equals' filter strategy.
     *
     * @param Builder $builder
     * @param string $column
     * @param mixed $value
     * @return Builder
     */
    public function apply(Builder $builder, string $column, mixed $value): Builder
    {
        return $builder->where($column, '>=', $value);
    }
}