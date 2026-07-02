<?php

namespace App\Services;

use App\DAO\NoteDAO;
use App\DTOs\Note\Create\CreateNoteDTO;
use App\DTOs\Note\Update\UpdateNoteDTO;

class NoteService
{
    public function __construct(
        private NoteDAO $dao
    ) {}

    public function store($model, CreateNoteDTO $noteDTO, $relationName = 'notes')
    {
        return $model->{$relationName}()->create($noteDTO->toArray());
    }

    public function update(int $id, UpdateNoteDTO $dto)
    {
        return $this->dao->update($id, $dto);
    }

    public function show(int $id)
    {
        return $this->dao->show($id);
    }

    public function destroy(int $id)
    {
        return $this->dao->destroy($id);
    }
}
