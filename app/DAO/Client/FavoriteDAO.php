<?php

namespace App\DAO\Client;

use App\DTOs\Client\Create\CreateFavoriteDTO;
use App\Exceptions\NotFoundException;
use App\Models\Client\Favorite;

class FavoriteDAO
{
    public function index(int $client_id)
    {
        return Favorite::where('client_id', $client_id)->with(['unit', 'client'])->get();
    }

    public function store(CreateFavoriteDTO $favoriteDTO)
    {
        return Favorite::create($favoriteDTO->toArray());
    }

    public function show(int $id)
    {
        return Favorite::find($id) ?? throw new NotFoundException("Favorite");
    }

    public function destroy(int $id)
    {
        $Favorite = $this->show($id);
        return $Favorite->delete();
    }
}
