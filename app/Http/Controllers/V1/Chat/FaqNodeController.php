<?php

namespace App\Http\Controllers\V1\Chat;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Chat\Faq\StoreFaqNodeRequest;
use App\Http\Requests\V1\Chat\Faq\UpdateFaqNodeRequest;
use App\DTOs\Chat\Faq\Create\CreateFaqNodeDTO;
use App\DTOs\Chat\Faq\Update\UpdateFaqNodeDTO;
use App\Services\Chat\FaqNodeService;
use App\Http\Resources\V1\Chat\Faq\ClientFaqNodeResource;
use App\Http\Resources\V1\Chat\Faq\AdminFaqNodeResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;

class FaqNodeController extends Controller
{
    use ResponseTrait;
    public function __construct(protected FaqNodeService $service) {}

    public function adminIndex()
    {
        $nodes = $this->service->getAdminTree();

        return $this->successCollection($nodes, AdminFaqNodeResource::class);
    }

    public function index()
    {
        $nodes = $this->service->getRootNodes();
        return $this->successCollection($nodes, ClientFaqNodeResource::class);
    }

    public function children(int $id)
    {
        $nodes = $this->service->getChildren($id);
        return $this->successCollection($nodes, ClientFaqNodeResource::class);
    }

    public function show(int $id)
    {
        $node = $this->service->show($id);
        return $this->useResource($node, AdminFaqNodeResource::class);
    }

    public function store(StoreFaqNodeRequest $request)
    {
        $node = $this->service->store($request->validated());

        return $this->useResource($node, AdminFaqNodeResource::class, __('messages.faq.created'), 201);
    }

    public function update(UpdateFaqNodeRequest $request, int $id)
    {
        $node = $this->service->update($id, $request->validated());

        return $this->useResource($node, AdminFaqNodeResource::class, __('messages.faq.updated'));
    }

    public function destroy(int $id)
    {
        $this->service->destroy($id);

        return $this->successResponse([], __('messages.faq.deleted'));
    }
}
