<?php

namespace App\DAO\RealEstate;

use App\DTOs\RealEstate\Create\CreateUnitDTO;
use App\DTOs\RealEstate\Update\UpdateUnitDTO;
use App\Exceptions\NotFoundException;
use App\Models\RealEstate\Unit;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UnitDAO
{

    public function getWithoutPag()
    {
        return Unit::with('attachments')->get();
    }

    public function getAllForAdmin(int $perPage = 15): LengthAwarePaginator
    {
        return Unit::query()
            ->with(['building', 'activeOffer'])
            ->latest()
            ->paginate($perPage);
    }

    public function getUnitsForClient(int $perPage = 15): LengthAwarePaginator
    {
        $user = Auth::user();

        return Unit::query()
            ->where('status', 'available')

            ->with(['attachments', 'activeOffer'])

            ->when($user && $user->client, function ($query) use ($user) {
                $query->withExists(['favorites' => function ($q) use ($user) {
                    $q->where('client_id', $user->client->id);
                }]);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function byBuilding(int $building_id, array $relations = [])
    {
        $defaultRelation = ['building.project', 'activeOffer'];
        $allRelations = array_merge($defaultRelation, $relations);
        return Unit::with($allRelations)->where('building_id', $building_id)->get();
    }

    public function store(array $data)
    {
        return Unit::create($data);
    }

    public function show(int $id)
    {
        return Unit::where('id', $id)->with(['attachments', 'building', 'activeOffer'])->first() ?? throw new NotFoundException("Unit");
    }

    protected function getBaseSearchQuery()
    {
        return Unit::query()
            ->select('units.*')
            ->join('buildings', 'units.building_id', '=', 'buildings.id')
            ->join('projects', 'buildings.project_id', '=', 'projects.id');
    }

    public function search(array $filters)
    {
        $query = $this->getBaseSearchQuery();

        $query->when(isset($filters['location_id']), function ($q) use ($filters) {
            $q->where('projects.location_id', $filters['location_id']);
        });

        $query->when(isset($filters['price_min']), function ($q) use ($filters) {
            $q->where('units.price', '>=', $filters['price_min']);
        });

        $query->when(isset($filters['price_max']), function ($q) use ($filters) {
            $q->where('units.price', '<=', $filters['price_max']);
        });

        $query->when(isset($filters['rooms_count']), function ($q) use ($filters) {
            $q->where('units.rooms_count', $filters['rooms_count']);
        });

        $query->when(isset($filters['type']), function ($q) use ($filters) {
            $q->where('units.type', $filters['type']);
        });

        $query->when(isset($filters['floor']), function ($q) use ($filters) {
            $q->where('units.floor', $filters['floor']);
        });

        $query->when(isset($filters['area_min']), function ($q) use ($filters) {
            $q->where('units.area', '>=', $filters['area_min']);
        });

        $query->when(isset($filters['area_max']), function ($q) use ($filters) {
            $q->where('units.area', '<=', $filters['area_max']);
        });

        return $query->with(['building.location'])
            ->paginate(12);
    }

    public function update(int $id, UpdateUnitDTO $UnitDTO)
    {
        $unit = $this->show($id);
        $unit->update($UnitDTO->toArray());
        return $unit;
    }

    public function destroy(int $id)
    {
        $unit = $this->show($id);
        return $unit->delete();
    }
}
