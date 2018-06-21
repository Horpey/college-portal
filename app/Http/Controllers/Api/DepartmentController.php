<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\DepartmentRequest;
use App\Services\DepartmentService;
use App\Services\FacultyService;
use App\Filters\DepartmentFilters;

class DepartmentController extends ApiController
{
    protected $service, $facultyService;

    public function __construct(DepartmentService $service, FacultyService $facultyService) {
        $this->service = $service;
        $this->facultyService = $facultyService;
    }

    public function service() {
        return $this->service;
    }

    public function show(Request $request, DepartmentFilters $filters, $id) {
        $department = $this->service()->repo()->department($id, $filters);
        $this->authorize('view', $department); /** ensure the current user has view rights */
        return $department;
    }

    public function index(Request $request, DepartmentFilters $filters) {
        $departments = $this->service()->repo()->departments($request->user(), $filters);
        return $departments;
    }

    public function destroy(Request $request, $id) {
        $department = $this->service()->repo()->department($id);
        $this->authorize('delete', $department); /** ensure the current user has delete rights */
        $this->service()->repo()->delete($id);
        return $this->ok();
    }

    public function store(DepartmentRequest $request) {
        $faculty = $this->facultyService->repo()->faculty($request->faculty_id);
        $department = $this->service()->repo()->create($request->all());
        return $this->json($department);
    }

    public function update(Request $request, $id) {
        $department = $this->service()->repo()->department($id);
        $this->authorize('update', $department);
        $department = $this->service()->repo()->update($id, $request->all());
        return $this->json($department);
    }
}