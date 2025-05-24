<?php

namespace Softzino\EmployeeManagementApi\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Softzino\EmployeeManagementApi\Services\DepartmentService;

class DepartmentController extends Controller{
    protected $departmentService;
    public function __construct(DepartmentService $departmentService){
        $this->departmentService = $departmentService;
    }

    public function index(){
        $departments = $this->departmentService->getAllDepartment();
        return response()->json($departments);
    }
}
