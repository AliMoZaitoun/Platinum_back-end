<?php

namespace App\Http\Controllers\V1\Core;

use App\DTOs\Core\CreateDepartmentDTO;
use App\DTOs\Core\Update\UpdateDepartmentDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Core\CreateDepartmentRequest;
use App\Services\Core\DepartmentService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private DepartmentService $departmentService
    ) {}

    public function index()
    {
        $items = $this->departmentService->index();
        return $this->successResponse($items);
    }

    public function store(CreateDepartmentRequest $request)
    {
        $departmentDTO = CreateDepartmentDTO::fromRequest($request->validated());

        $item = $this->departmentService->store($departmentDTO);
        return $this->successResponse($item, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $item = $this->departmentService->show($id);
        return $this->successResponse($item);
    }

    public function update(int $id, Request $request)
    {
        $departmentDTO = UpdateDepartmentDTO::fromRequest($request->all());

        $updatedItem = $this->departmentService->update($id, $departmentDTO);
        return $this->successResponse($updatedItem, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->departmentService->destroy($id);
        return $this->successResponse(null, __('messages.common.deleted'));
    }
}
