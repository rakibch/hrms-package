<?php

namespace Softzino\Support\Tests\Unit;

use Mockery;
use Mockery\MockInterface;
use Softzino\Support\Repository;
use Softzino\Support\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RepositoryTest extends TestCase
{
    private MockInterface $model;
    private MockInterface $builder;
    private Repository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = Mockery::mock(Model::class);
        $this->builder = Mockery::mock(Builder::class);

        // Setup the model to return the builder when query() is called
        $this->model->shouldReceive('query')->andReturn($this->builder);

        // Create a concrete implementation of the abstract Repository class
        $this->repository = new class ($this->model, $this->builder) extends Repository {
            // No need to implement anything as Repository already implements all methods
        };
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_find_method_returns_model_when_id_is_scalar(): void
    {
        // Arrange
        $id = 1;
        $expectedModel = Mockery::mock(Model::class);
        $columns = ['*'];

        $this->builder->shouldReceive('find')
            ->once()
            ->with($id, $columns)
            ->andReturn($expectedModel);

        // Act
        $result = $this->repository->find($id);

        // Assert
        $this->assertSame($expectedModel, $result);
    }

    public function test_find_method_returns_collection_when_id_is_array(): void
    {
        // Arrange
        $ids = [1, 2, 3];
        $expectedCollection = Mockery::mock(Collection::class);
        $columns = ['*'];

        $this->builder->shouldReceive('find')
            ->once()
            ->with($ids, $columns)
            ->andReturn($expectedCollection);

        // Act
        $result = $this->repository->find($ids);

        // Assert
        $this->assertSame($expectedCollection, $result);
    }

    public function test_all_method_returns_collection(): void
    {
        // Arrange
        $expectedCollection = Mockery::mock(Collection::class);
        $columns = ['*'];

        $this->builder->shouldReceive('get')
            ->once()
            ->with($columns)
            ->andReturn($expectedCollection);

        // Act
        $result = $this->repository->all();

        // Assert
        $this->assertSame($expectedCollection, $result);
    }

    public function test_all_method_with_custom_columns(): void
    {
        // Arrange
        $expectedCollection = Mockery::mock(Collection::class);
        $columns = ['id', 'name'];

        $this->builder->shouldReceive('get')
            ->once()
            ->with($columns)
            ->andReturn($expectedCollection);

        // Act
        $result = $this->repository->all($columns);

        // Assert
        $this->assertSame($expectedCollection, $result);
    }

    public function test_paginate_method_returns_paginator(): void
    {
        // Arrange
        $perPage = 15;
        $columns = ['*'];
        $pageName = 'page';
        $expectedPaginator = Mockery::mock(LengthAwarePaginator::class);

        $this->builder->shouldReceive('paginate')
            ->once()
            ->with($perPage, $columns, $pageName)
            ->andReturn($expectedPaginator);

        // Act
        $result = $this->repository->paginate();

        // Assert
        $this->assertSame($expectedPaginator, $result);
    }

    public function test_paginate_method_with_custom_parameters(): void
    {
        // Arrange
        $perPage = 10;
        $columns = ['id', 'name'];
        $pageName = 'custom_page';
        $expectedPaginator = Mockery::mock(LengthAwarePaginator::class);

        $this->builder->shouldReceive('paginate')
            ->once()
            ->with($perPage, $columns, $pageName)
            ->andReturn($expectedPaginator);

        // Act
        $result = $this->repository->paginate($perPage, $columns, $pageName);

        // Assert
        $this->assertSame($expectedPaginator, $result);
    }

    public function test_create_method_returns_model(): void
    {
        // Arrange
        $data = ['name' => 'Test'];
        $expectedModel = Mockery::mock(Model::class);

        $this->builder->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturn($expectedModel);

        // Act
        $result = $this->repository->create($data);

        // Assert
        $this->assertSame($expectedModel, $result);
    }

    public function test_update_method_with_model_instance(): void
    {
        // Arrange
        $modelToUpdate = Mockery::mock(Model::class);
        $data = ['name' => 'Updated Test'];

        $modelToUpdate->shouldReceive('update')
            ->once()
            ->with($data)
            ->andReturn(true);
        $modelToUpdate->shouldReceive('refresh')
            ->once()
            ->andReturn($modelToUpdate);

        // Act
        $result = $this->repository->update($modelToUpdate, $data);

        // Assert
        $this->assertSame($modelToUpdate, $result);
    }

    public function test_update_method_with_id(): void
    {
        // Arrange
        $id = 1;
        $data = ['name' => 'Updated Test'];
        $foundModel = Mockery::mock(Model::class);

        $this->builder->shouldReceive('find')
            ->once()
            ->with($id, ['*'])
            ->andReturn($foundModel);
        $foundModel->shouldReceive('update')
            ->once()
            ->with($data)
            ->andReturn(true);
        $foundModel->shouldReceive('refresh')
            ->once()
            ->andReturn($foundModel);

        // Act
        $result = $this->repository->update($id, $data);

        // Assert
        $this->assertSame($foundModel, $result);
    }

    public function test_update_method_returns_null_when_model_not_found(): void
    {
        // Arrange
        $id = 999;
        $data = ['name' => 'Updated Test'];

        $this->builder->shouldReceive('find')
            ->once()
            ->with($id, ['*'])
            ->andReturn(null);

        // Act
        $result = $this->repository->update($id, $data);

        // Assert
        $this->assertNull($result);
    }

    public function test_delete_method_with_model_instance(): void
    {
        // Arrange
        $modelToDelete = Mockery::mock(Model::class);

        $modelToDelete->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        // Act
        $result = $this->repository->delete($modelToDelete);

        // Assert
        $this->assertTrue($result);
    }

    public function test_delete_method_with_id(): void
    {
        // Arrange
        $id = 1;
        $foundModel = Mockery::mock(Model::class);

        $this->builder->shouldReceive('find')
            ->once()
            ->with($id, ['*'])
            ->andReturn($foundModel);

        $foundModel->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        // Act
        $result = $this->repository->delete($id);

        // Assert
        $this->assertTrue($result);
    }

    public function test_delete_method_returns_false_when_model_not_found(): void
    {
        // Arrange
        $id = 999;

        $this->builder->shouldReceive('find')
            ->once()
            ->with($id, ['*'])
            ->andReturn(null);

        // Act
        $result = $this->repository->delete($id);

        // Assert
        $this->assertFalse($result);
    }

    public function test_delete_method_returns_false_when_exception_thrown(): void
    {
        // Arrange
        $id = 1;
        $foundModel = Mockery::mock(Model::class);

        $this->builder->shouldReceive('find')
            ->once()
            ->with($id, ['*'])
            ->andReturn($foundModel);

        $foundModel->shouldReceive('delete')
            ->once()
            ->andThrow(new \Exception('Delete failed'));

        // Act
        $result = $this->repository->delete($id);

        // Assert
        $this->assertFalse($result);
    }
}
