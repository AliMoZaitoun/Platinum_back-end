<?php

namespace App\Http\Controllers\V1\Client;

use App\DTOs\Client\Create\CreateFavoriteDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Client\StoreFavoriteRequest;
use App\Http\Resources\V1\RealEstate\FavoriteResource;
use App\Services\Client\FavoriteService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private FavoriteService $favoriteService
    ) {}

    public function index()
    {
        $favorites = $this->favoriteService->index();
        return $this->successCollection($favorites, FavoriteResource::class);
    }

    public function store(Request $request, int $unit_id)
    {
        $favoriteDTO = CreateFavoriteDTO::fromValues(
            $unit_id,
            $request->user()->client->id
        );

        $favorite = $this->favoriteService->store($favoriteDTO);

        return $this->useResource($favorite, FavoriteResource::class, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $favorite = $this->favoriteService->show($id);
        return $this->useResource($favorite, FavoriteResource::class);
    }

    public function destroy(int $unit_id)
    {
        $this->favoriteService->destroy($unit_id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
