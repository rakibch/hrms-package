<?php

declare(strict_types=1);

namespace Softzino\Support\Filtering\Strategies;

use Illuminate\Database\Eloquent\Builder;
use Softzino\Support\Contracts\FilterStrategyContract;
/**
 * Strategy for applying an 'in' filter.
 */
class InStrategy implements FilterStrategyContract
{
    /**
     * Apply the 'in' filter strategy.
     *
     * @param Builder $builder
     * @param string $column
     * @param mixed $value Should be an array of values.
     * @return Builder
     */
    public function apply(Builder $builder, string $column, mixed $value): Builder
    {
        if (!is_array($value)) {
            throw new \InvalidArgumentException('Value for "in" strategy must be an array.');
        }
        return $builder->whereIn($column, $value);
    }
}