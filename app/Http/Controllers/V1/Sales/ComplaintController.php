<?php

namespace App\Http\Controllers\V1\Sales;

use App\DTOs\Sales\Create\CreateComplaintDTO;
use App\DTOs\Sales\Update\UpdateComplaintDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\Create\CreateComplaintRequest;
use App\Http\Requests\V1\Sales\Update\UpdateComplaintRequest;
use App\Http\Resources\V1\Resourcs\ComplaintResource;
use App\Services\Sales\ComplaintService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ComplaintService $service
    ) {}

    public function index()
    {
        $complaints = $this->service->index();

        return $this->successCollection($complaints, ComplaintResource::class);
    }

    public function store(CreateComplaintRequest $request)
    {
        $user = $request->user();

        $dto = CreateComplaintDTO::fromRequest($user->id, $user->client->id, $request->validated());

        $this->service->store($dto, $request->file('attachments'));

        return $this->successResponse([], __('messages.common.stored'), 201);
    }

    public function update(int $id, UpdateComplaintRequest $request)
    {
        $dto = UpdateComplaintDTO::fromRequest($request->validated());
        $complaint = $this->service->update($id, $dto);

        return $this->useResource($complaint, ComplaintResource::class);
    }

    public function updateStatus(int $id, UpdateComplaintRequest $request)
    {
        $dto = UpdateComplaintDTO::fromRequest($request->validated());
        $complaint = $this->service->update($id, $dto);

        return $this->useResource($complaint, ComplaintResource::class);
    }

    public function destroy(int $id)
    {
        $this->service->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
