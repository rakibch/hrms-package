<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function create(array $data): Model;

    public function update(Model $model, array $data): bool;

    public function delete(Model $model): bool;

    public function all(array $options = []): Collection|LengthAwarePaginator;

    public function getById(int $id, array $options = []): ?Model;
}
