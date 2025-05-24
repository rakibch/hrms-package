<?php

declare(strict_types=1);

namespace Softzino\Support\Filtering\Strategies;

use Illuminate\Database\Eloquent\Builder;
use Softzino\Support\Contracts\FilterStrategyContract;

/**
 * Strategy for applying a 'not like' filter.
 */
class NotLikeStrategy implements FilterStrategyContract
{
    /**
     * Apply the 'not like' filter strategy.
     *
     * @param Builder $builder
     * @param string $column
     * @param mixed $value
     * @return Builder
     */
    public function apply(Builder $builder, string $column, mixed $value): Builder
    {
        // Assuming the value already contains the necessary wildcards (e.g., '%value%')
        return $builder->where($column, 'not like', $value);
    }
}