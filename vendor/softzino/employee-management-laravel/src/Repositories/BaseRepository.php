<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Softzino\EmployeeManagement\Contracts\Repositories\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(Model $model, array $data): bool
    {
        return $model->update($data);
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    /**
     * Retrieve all departments with optional relations, filters, and sorting.
     */
    public function all(array $options = []): Collection|LengthAwarePaginator
    {
        $query = $this->model->query();

        // Eager load relations if provided
        if (! empty($options['with'])) {
            $query->with($options['with']);
        }

        // WithCount for related models
        if (! empty($options['withCount'])) {
            $query->withCount($options['withCount']);
        }

        // Apply filters if provided
        if (! empty($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                $query->where($field, $value);
            }
        }

        // Apply sorting if provided
        if (! empty($options['orderBy'])) {
            $query->orderBy($options['orderBy'][0], $options['orderBy'][1] ?? 'desc');
        }

        // Check if pagination is requested
        if (! empty($options['paginate'])) {
            $perPage = $options['paginate']['perPage'] ?? 10;
            $page = $options['paginate']['page'] ?? 1;

            return $query->paginate($perPage, ['*'], 'page', $page);
        }

        // Default: return all results
        return $query->get();
    }

    public function getById(int $id, array $options = []): ?Model
    {
        $query = $this->model->query();

        // Eager load relations
        if (! empty($options['with'])) {
            $query->with($options['with']);
        }

        // WithCount for related models
        if (! empty($options['withCount'])) {
            $query->withCount($options['withCount']);
        }

        // Apply additional filters if provided
        if (! empty($options['filters'])) {
            foreach ($options['filters'] as $field => $value) {
                $query->where($field, $value);
            }
        }

        return $query->find($id);
    }
}
