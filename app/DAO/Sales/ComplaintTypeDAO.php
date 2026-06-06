<?php

namespace App\DAO\Sales;

use App\DTOs\Sales\Create\CreateComplaintTypeDTO;
use App\DTOs\Sales\Update\UpdateComplaintTypeDTO;
use App\Exceptions\NotFoundException;
use App\Models\Sales\ComplaintType;

class ComplaintTypeDAO
{
    public function index()
    {
        return ComplaintType::all();
    }

    public function store(array $data)
    {
        return ComplaintType::create($data);
    }

    public function show(int $id)
    {
        return ComplaintType::where('id', $id)->first() ?? throw new NotFoundException("ComplaintType");
    }

    public function update(int $id, UpdateComplaintTypeDTO $dto)
    {
        $type = $this->show($id);
        return $type->update($dto->toArray());
    }

    public function destroy(int $id)
    {
        return $this->show($id)->delete();
    }
}
