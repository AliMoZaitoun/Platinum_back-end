<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RealEstate\ConstructionInsightResource;
use App\Services\RealEstate\ConstructionInsightService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ConstructionInsightController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private ConstructionInsightService $service
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['building_id', 'severity', 'is_read', 'per_page']);
        $insights = $this->service->index($filters);

        return $this->successCollection($insights, ConstructionInsightResource::class, __('messages.insight.retrieved_successfully'));
    }

    public function markAsRead(int $id)
    {
        $this->service->markAsRead($id);

        return $this->successResponse([], __('messages.insight.marked_as_read'));
    }
}
