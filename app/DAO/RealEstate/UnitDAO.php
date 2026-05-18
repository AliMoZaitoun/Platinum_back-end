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
            ->with(['building'])
            ->latest()
            ->paginate($perPage);
    }

    public function getUnitsForClient(int $perPage = 15): LengthAwarePaginator
    {
        $user = Auth::user();

        return Unit::query()
            ->where('status', 'available')

            ->with(['attachments'])

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
        $defaultRelation = ['building.project'];
        $allRelations = array_merge($defaultRelation, $relations);
        return Unit::with($allRelations)->where('building_id', $building_id)->get();
    }

    public function store(array $data)
    {
        return Unit::create($data);
    }

    public function show(int $id)
    {
        return Unit::where('id', $id)->with(['attachments', 'building'])->first() ?? throw new NotFoundException("Unit");
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

        if (!empty($filters['location_id'])) {
            $query->where('projects.location_id', $filters['location_id']);
        }

        if (!empty($filters['price_min'])) {
            $query->where('units.price', '>=', $filters['price_min']);
        }

        if (!empty($filters['price_max'])) {
            $query->where('units.price', '<=', $filters['price_max']);
        }

        if (isset($filters['rooms_count']) && $filters['rooms_count'] !== '') {
            $query->where('units.rooms_count', $filters['rooms_count']);
        }

        if (!empty($filters['type'])) {
            $query->where('units.type', $filters['type']);
        }

        return $query->with(['building.project.location'])
            ->paginate(12);
    }

    public function update(int $id, UpdateUnitDTO $UnitDTO)
    {
        $unit = $this->show($id);
        $unit->update($UnitDTO->toArray());
        return $unit;
    }

    public function destroy($id)
    {
        $unit = $this->show($id);
        return $unit->delete();
    }
}
