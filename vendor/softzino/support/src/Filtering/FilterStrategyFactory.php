<?php

declare(strict_types=1);

namespace Softzino\Support\Filtering;

use InvalidArgumentException;
use Softzino\Support\Filtering\Strategies\BetweenStrategy;
use Softzino\Support\Filtering\Strategies\EqualsStrategy;
use Softzino\Support\Contracts\FilterStrategyContract;
use Softzino\Support\Filtering\Strategies\GreaterThanOrEqualsStrategy;
use Softzino\Support\Filtering\Strategies\GreaterThanStrategy;
use Softzino\Support\Filtering\Strategies\InStrategy;
use Softzino\Support\Filtering\Strategies\LessThanOrEqualsStrategy;
use Softzino\Support\Filtering\Strategies\LessThanStrategy;
use Softzino\Support\Filtering\Strategies\LikeStrategy;
use Softzino\Support\Filtering\Strategies\NotEqualsStrategy;
use Softzino\Support\Filtering\Strategies\NotInStrategy;
use Softzino\Support\Filtering\Strategies\NotLikeStrategy;

/**
 * Factory for creating filter strategy instances.
 */
class FilterStrategyFactory
{
    /**
     * Mapping of operators to strategy classes.
     *
     * @var array<string, class-string<FilterStrategyContract>>
     */
    protected static array $strategies = [
        '=' => EqualsStrategy::class,
        '>' => GreaterThanStrategy::class,
        '<' => LessThanStrategy::class,
        '>=' => GreaterThanOrEqualsStrategy::class,
        '<=' => LessThanOrEqualsStrategy::class,
        '!=' => NotEqualsStrategy::class,
        'like' => LikeStrategy::class,
        'not like' => NotLikeStrategy::class,
        'in' => InStrategy::class,
        'not in' => NotInStrategy::class,
        'between' => BetweenStrategy::class,
    ];

    /**
     * Create a filter strategy instance based on the operator.
     *
     * @param string $operator The comparison operator.
     * @return FilterStrategyContract The filter strategy instance.
     * @throws InvalidArgumentException If the operator is invalid.
     */
    public static function make(string $operator): FilterStrategyContract
    {
        if (!isset(static::$strategies[$operator])) {
            throw new InvalidArgumentException('Invalid comparison operator: ' . $operator);
        }

        $strategyClass = static::$strategies[$operator];
        return new $strategyClass();
    }

    /**
     * Register a custom strategy or override an existing one.
     *
     * @param string $operator
     * @param class-string<FilterStrategyContract> $strategyClass
     * @return void
     */
    public static function register(string $operator, string $strategyClass): void
    {
        static::$strategies[$operator] = $strategyClass;
    }
}