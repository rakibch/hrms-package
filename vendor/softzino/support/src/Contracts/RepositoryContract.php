<?php

declare(strict_types=1);

namespace Softzino\Support\Contracts;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TQuery of \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @author Foysal Ahmed <foysal20x@gmail.com>
 */

interface RepositoryContract
{
    /**
     * Make a query builder instance.
     *
     * @param TQuery|null $query
     * @return TQuery
    */

    public function query($query = null);

    /**
     * Get all records.
     * @param array<string>|string $columns
     * @return \Illuminate\Database\Eloquent\Collection<int, TModel>
     */
    public function all($columns = ['*']);

    /**
     * Create a new record.
     *
     * @param array<string, mixed> $data
     * @return ?TModel
     */
    public function create(array $data);

    /**
     * Update an existing record.
     *
     * @param int|string|TModel $id
     * @param array<string, mixed> $data
     * @return ?TModel
     */
    public function update($id, array $data);

    /**
     * Delete a record.
     *
     * @param int|string|TModel $id
     * @return bool
     */
    public function delete($id): bool;

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
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page');

    /**
     * Find a record by its ID.
     *
     * @param mixed $id
     * @param array<string>|string $columns
     * @return ($id is (\Illuminate\Contracts\Support\Arrayable<array-key, mixed>|array<mixed>) ? \Illuminate\Database\Eloquent\Collection<int, TModel> : TModel|null)
     */
    public function find($id, $columns = ['*']);

    
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
    public function usingFilter(array $filter = []): static;

}
