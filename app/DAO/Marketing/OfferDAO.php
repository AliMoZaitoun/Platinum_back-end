<?php

namespace App\DAO\Marketing;

use App\DTOs\Marketing\Create\CreateOfferDTO;
use App\DTOs\Marketing\Update\UpdateOfferDTO;
use App\Exceptions\NotFoundException;
use App\Models\Marketing\Offer;

class OfferDAO
{

    public function index(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['offerable'];
        $allRelations = array_merge($defaultRelations, $relations);
        return Offer::query()
            ->with($allRelations)
            ->latest()
            ->paginate($perPage);
    }

    public function activeOffers(array $relations = [], int $perPage = 15)
    {
        $defaultRelations = ['offerable'];
        $allRelations = array_merge($defaultRelations, $relations);

        return Offer::query()
            ->with($allRelations)
            ->active()
            ->latest()
            ->paginate($perPage);
    }

    public function store(CreateOfferDTO $dto)
    {
        return Offer::create($dto->toArray());
    }

    public function show(int $id)
    {
        return Offer::where('id', $id)->with(['offerable'])->first() ?? throw new NotFoundException("Offer");
    }

    public function update(int $id, UpdateOfferDTO $dto)
    {
        $offer = $this->show($id);
        $offer->update($dto->toArray());
        return $offer->refresh();
    }

    public function deactivatePreviousOffers(string $offerableType, int $offerableId): void
    {
        Offer::where('offerable_type', $offerableType)
            ->where('offerable_id', $offerableId)
            ->where('status', true)
            ->update(['status' => false]);
    }

    public function destroy(int $id)
    {
        $ad = $this->show($id);
        return $ad->delete();
    }
}
