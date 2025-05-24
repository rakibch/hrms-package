<?php

namespace Softzino\EmployeeManagementApi\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    public function create(array $data): Model;

    public function update(Model $model, array $data): Model;

    public function delete(Model $model): bool;

    public function all(array $relations = []): Collection;

    public function getById(int $id, ?array $relations = null): ?Model;
}
