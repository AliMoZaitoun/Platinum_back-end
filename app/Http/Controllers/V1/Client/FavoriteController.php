<?php

namespace App\Http\Controllers\V1\Client;

use App\DTOs\Client\Create\CreateFavoriteDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFavoriteRequest;
use App\Services\Client\FavoriteService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ResponseTrait;
    public function __construct(
        private FavoriteService $favoriteService
    ) {}

    public function index()
    {
        $favorites = $this->favoriteService->index();
        return $this->successResponse($favorites);
    }

    public function store(int $unit_id)
    {
        $favoriteDTO = new CreateFavoriteDTO(null, $unit_id);
        $favorite = $this->favoriteService->store($favoriteDTO);

        return $this->successResponse($favorite, __('messages.common.stored'), 201);
    }

    public function show(int $id)
    {
        $favorite = $this->favoriteService->show($id);
        return $this->successResponse($favorite);
    }

    public function destroy(int $id)
    {
        $this->favoriteService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
