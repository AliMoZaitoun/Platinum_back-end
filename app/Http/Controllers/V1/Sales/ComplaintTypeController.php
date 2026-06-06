<?php

namespace App\Http\Controllers\V1\Sales;

use App\DTOs\Sales\Create\CreateComplaintTypeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\CreateComplaintTypeRequest;
use App\Http\Resources\V1\Sales\ComplaintTypeResource;
use App\Services\Sales\ComplaintTypeService;
use App\Traits\ResponseTrait;

class ComplaintTypeController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ComplaintTypeService $service
    ) {}

    public function index()
    {
        $complaints = $this->service->index();

        return $this->successCollection($complaints, ComplaintTypeResource::class);
    }

    public function store(CreateComplaintTypeRequest $request)
    {
        $user = $request->user();
        $dto = CreateComplaintTypeDTO::fromRequest($user->id, $request->validated());
        $this->service->store($dto);

        return $this->successResponse([], __('messages.common.stored'), 201);
    }

    public function destroy(int $id)
    {
        $this->service->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
