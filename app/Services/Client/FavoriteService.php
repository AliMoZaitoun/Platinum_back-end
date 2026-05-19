<?php

namespace App\Services\Client;

use App\DAO\Client\FavoriteDAO;
use App\DTOs\Client\Create\CreateFavoriteDTO;
use App\Exceptions\UnitAlreadyFavoritedException;
use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function __construct(
        private FavoriteDAO $favoriteDAO,
    ) {}

    public function index()
    {
        $client = Auth::user()->client;
        return $this->favoriteDAO->index($client->id);
    }

    public function store(CreateFavoriteDTO $dto)
    {
        $exists = $this->favoriteDAO->exists($dto->client_id, $dto->unit_id);

        if ($exists) {
            throw new UnitAlreadyFavoritedException();
        }

        return $this->favoriteDAO->store($dto);
    }

    public function show(int $id)
    {
        return $this->favoriteDAO->show($id);
    }

    public function destroy(int $id)
    {
        return $this->favoriteDAO->destroy($id);
    }
}
