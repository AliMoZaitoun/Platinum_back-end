<?php

namespace App\Services\Client;

use App\DAO\Client\FavoriteDAO;
use App\DTOs\Client\Create\CreateFavoriteDTO;
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

    public function store(CreateFavoriteDTO $favoriteDTO)
    {
        $client = Auth::user()->client;
        $favoriteDTO->client_id = $client->id;
        return $this->favoriteDAO->store($favoriteDTO);
    }

    public function show($id)
    {
        return $this->favoriteDAO->show($id);
    }

    public function destroy($id)
    {
        return $this->favoriteDAO->destroy($id);
    }
}
