<?php

declare(strict_types=1);

namespace Softzino\Support;

use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Softzino\Support\Contracts\RepositoryContract;
use Softzino\Support\Filtering\FilterStrategyFactory;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TQuery of \Illuminate\Database\Eloquent\Builder<TModel>
 * @implements RepositoryContract<Model, TQuery>
 *
 * @author Foysal Ahmed <foysal20x@gmail.com>
 */
abstract class Repository implements RepositoryContract
{
    /**
     * @var TModel $model
    */
    protected $model;

    /**
     * @var TQuery $builder
    */
    protected $builder;


    /**
     * Repository constructor.
     *
     * @param TModel|null $model
     * @param TQuery|null $builder
     */
    public function __construct(?Model $model, ?Builder $builder = null)
    {
        $this->model = $model;

        if ($builder) {
            $this->builder = $builder;
        }

        if (!$builder) {
            $this->builder = $this->model::query();
        }
    }

    /**
     * Make a query builder instance.
     *
     * @param TQuery|null $query
     * @return TQuery
     */

    public function query($query = null)
    {

        if (is_null($query)) {
            return $this->builder;
        }

        return $this->builder = $query;
    }

    /**
     * Find a record by its ID.
     *
     * @param mixed $id
     * @param array<string>|string $columns
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel|null)
     */
    public function find($id, $columns = ['*'])
    {
        return $this->query()->find($id, $columns);
    }

    /**
     * Get all records.
     * @param array<string>|string $columns
     * @return \Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public function all($columns = ['*'])
    {
        return $this->query()->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }

    /**
     * Paginate records.
     *
     * @param int $perPage
     * @param array<string>|string $columns
     * @param string $pageName
     * @return \Illuminate\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page')
    {
        return $this->query()->paginate($perPage, $columns, $pageName);
    }

    /**
     * Create a new record.
     *
     * @param array<string, mixed> $data
     * @return ?TModel
     */
    public function create(array $data)
    {
        return $this->query()->create($data);
    }

    /**
     * Update an existing record.
     *
     * @param int|string|TModel $id
     * @param array<string, mixed> $data
     * @return ?TModel
     */
    public function update($id, $data)
    {
        $model = $id instanceof Model ? $id : $this->find($id);
        if (is_null($model)) {
            return null;
        }
        $updated = $model->update($data);
        if ($updated) {
            return $model->refresh();
        }
        return $model;
    }

    /**
     * Delete a record.
     *
     * @param int|string|TModel $id
     * @return bool
     */
    public function delete($id): bool
    {
        $model = $id instanceof Model ? $id : $this->find($id);
        try {
            if ($model) {
                return (bool) $model->delete();
            }
        } catch (\Throwable) {
            return false;
        }
        return false;
    }

    /**
     * Apply filters to the query builder with support for both eloquent-filtering package and custom filtering.
     *
     * @param array<string, mixed>|array<array<string, mixed>> $filter Array of filter conditions.
     *        For eloquent-filtering package: Array of filter specifications with target, type and value
     *        For custom filtering: Key-value pairs where key is column name and value is either:
     *          - A string for exact match
     *          - An array with operator and value for comparison (e.g. ['>', 100])
     *
     * @return static Returns a new repository instance with filtered query builder
     *
     * @example Package usage (requires indexzer0/eloquent-filtering)
     * ```php
     * $userRepository->usingFilter([
     *     [
     *         'target' => 'name',
     *         'type'   => '$eq',
     *         'value'  => 'John'
     *     ],
     *     [
     *         'target' => 'age',
     *         'type'   => '$gt',
     *         'value'  => 30
     *     ]
     * ])->all();
     * ```
     * @example Custom filtering (basic)
     * ```php
     * $userRepository->usingFilter(['name' => 'John'])->all();
     * ```
     * $userRepository->usingFilter(['status' => 'active'])->all();
     *
     * @example Custom filtering (with comparison operators)
     * ```php
     * $userRepository->usingFilter([
     *     'price' => ['>', 100],
     *     'created_at' => ['>=', '2023-01-01']
     * ])->paginate();
     * ```
     * @see \IndexZer0\EloquentFiltering\Contracts\IsFilterable
     */
    public function usingFilter(array $filter = []): static
    {

        /**
         * Applies filtering to the query using the indexzer0/eloquent-filtering package.
         *
         * To use this functionality:
         * 1. Install the package: composer require indexzer0/eloquent-filtering
         * 2. run artisan command `php artisan eloquent-filtering:install`
         * 3. Implement the IsFilterable interface on your model
         *
         * If the package is not installed, you can implement custom filtering logic
         * by overriding this method in your repository class.
         *
         * @see \IndexZer0\EloquentFiltering\Contracts\IsFilterable
         */
        $filterableContract = '\IndexZer0\EloquentFiltering\Contracts\IsFilterable';

        if (interface_exists($filterableContract, false)) {
            if ($this->model instanceof $filterableContract) {
                //@phpstan-ignore-next-line
                return new static($this->model, $this->model->filter($filter));
            }
        }

        // Handle custom filtering using Strategy pattern
        $builder = $this->query();

        foreach ($filter as $column => $condition) {
            try {
                if (is_array($condition)) {

                    if (count($condition) !== 2) {
                        throw new InvalidArgumentException('Filter condition array must have exactly two elements: [operator, value].');
                    }

                    [$operator, $value] = $condition;
                    
                    $builder = FilterStrategyFactory::make($operator)->apply($builder, $column, $value);

                } elseif (is_string($condition)) {
                    $builder->where($column, $condition);
                } else {
                     throw new InvalidArgumentException('Invalid filter condition type for column: ' . $column);
                }
            } catch (InvalidArgumentException $e) {
                // Optionally log the error or handle it as needed
                // For now, rethrow the exception
                throw $e;
            }
        }

        return new static($this->model, $builder);
    }

}
