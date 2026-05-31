<?php

namespace App\Http\Controllers\V1\Sales;

use App\DAO\Sales\ComplaintTypeService;
use App\DTOs\Sales\Create\CreateComplaintTypeDTO;
use App\DTOs\Sales\Update\UpdateComplaintTypeDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Sales\Create\CreateComplaintRequest;
use App\Http\Resources\V1\Resourcs\ComplaintResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ComplaintTypeController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ComplaintTypeService $service
    ) {}

    public function index()
    {
        $complaints = $this->service->index();

        return $this->successCollection($complaints, ComplaintResource::class);
    }

    public function store(Request $request)
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
