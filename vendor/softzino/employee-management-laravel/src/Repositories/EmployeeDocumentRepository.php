<?php

namespace Softzino\EmployeeManagement\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Softzino\EmployeeManagement\Contracts\Repositories\EmployeeDocumentRepositoryInterface;
use Softzino\EmployeeManagement\Models\EmployeeDocument;

class EmployeeDocumentRepository implements EmployeeDocumentRepositoryInterface
{
    public function storeDocument(int $employeeId, array $documentData): EmployeeDocument
    {
        $documentData['employee_id'] = $employeeId;

        return EmployeeDocument::create($documentData);
    }

    public function updateDocument(EmployeeDocument $document, array $documentData): bool
    {
        return $document->update($documentData);
    }

    public function deleteDocument(EmployeeDocument $document): bool
    {
        return $document->delete();
    }

    public function getEmployeeDocuments(int $employeeId): Collection
    {
        return EmployeeDocument::where('employee_id', $employeeId)->get();
    }
}
