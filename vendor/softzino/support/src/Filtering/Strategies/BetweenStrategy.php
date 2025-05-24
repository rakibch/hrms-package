<?php

declare(strict_types=1);

namespace Softzino\Support\Filtering\Strategies;

use Illuminate\Database\Eloquent\Builder;
use Softzino\Support\Contracts\FilterStrategyContract;

/**
 * Strategy for applying a 'between' filter.
 */
class BetweenStrategy implements FilterStrategyContract
{
    /**
     * Apply the 'between' filter strategy.
     *
     * @param Builder $builder
     * @param string $column
     * @param mixed $value Should be an array with two elements [min, max].
     * @return Builder
     */
    public function apply(Builder $builder, string $column, mixed $value): Builder
    {
        if (!is_array($value) || count($value) !== 2) {
            throw new \InvalidArgumentException('Value for "between" strategy must be an array with two elements.');
        }
        return $builder->whereBetween($column, $value);
    }
}