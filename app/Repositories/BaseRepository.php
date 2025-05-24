<?php

namespace App\Repositories;

use App\Contracts\Repositories\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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

    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model;
    }

    public function delete(Model $model): bool
    {
        return $model->delete();
    }

    public function all(array $relations = []): Collection
    {
        $query = $this->query();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->get();
    }

    public function getById(int $id, ?array $relations = null): ?Model
    {
        $query = $this->query();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->findOrFail($id);
    }
}
