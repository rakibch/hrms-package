<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers\Web\Document;


use Illuminate\Http\RedirectResponse;
use Softzino\EmployeeManagement\Models\EmployeeDocument;
use Softzino\EmployeeManagement\Repositories\EmployeeDocumentRepository;

class Delete
{
    public function __invoke(int $documentId, EmployeeDocumentRepository $documentRepository): RedirectResponse
    {
        $document = EmployeeDocument::find($documentId)->first();

        if (! $document) {
            return redirect()
                ->back()
                ->withErrors(['error' => 'Document not found.']);
        }

        try {
            $documentRepository->deleteDocument($document);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to delete document: ' . $e->getMessage()]);
        }
        return redirect()
            ->back()
            ->with('success', 'document deleted');
    }
}
