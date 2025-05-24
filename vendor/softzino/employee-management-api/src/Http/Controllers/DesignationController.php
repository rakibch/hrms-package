<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Softzino\EmployeeManagement\Models\Designation;
use Softzino\EmployeeManagementApi\Services\DesignationService;

class DesignationController
{

    // Inject Designation into the controller
    public function __construct(protected DesignationService $designationService)
    {
    }

    /**
     * Get all Designations.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $designations = $this->designationService->getAllDesignations();

        return response()->json($designations);
    }

    /**
     * Get a specific designation by ID.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        // Call the service to get a designation by ID
        $designation = $this->designationService->getDesignationById($id);

        return response()->json($designation);
    }

    public function toggleStatus(int $id): JsonResponse
    {
       $response =  $this->designationService->toggleStatus($id);

        return response()->json([
            'success' => $response,
        ]);
    }

}
