<?php

namespace Softzino\EmployeeManagement\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Models\EmployeeDocument;

interface EmployeeDocumentRepositoryInterface
{
    public function storeDocument(int $employeeId, array $documentData): EmployeeDocument;

    public function updateDocument(EmployeeDocument $document, array $documentData): bool;

    public function deleteDocument(EmployeeDocument $document): bool;

    public function getEmployeeDocuments(int $employeeId): Collection;
}
