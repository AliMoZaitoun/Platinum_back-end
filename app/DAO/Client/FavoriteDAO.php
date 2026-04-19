<?php

namespace App\DAO\Client;

use App\DTOs\Client\Create\CreateFavoriteDTO;
use App\Exceptions\NotFoundException;
use App\Models\Favorite;

class FavoriteDAO
{
    public function index($client_id)
    {
        return Favorite::where('client_id', $client_id)->get();
    }

    public function store(CreateFavoriteDTO $favoriteDTO)
    {
        return Favorite::create($favoriteDTO->toArray());
    }

    public function show($id)
    {
        return Favorite::find($id) ?? throw new NotFoundException("Favorite");
    }

    public function destroy($id)
    {
        $Favorite = $this->show($id);
        return $Favorite->delete();
    }
}
