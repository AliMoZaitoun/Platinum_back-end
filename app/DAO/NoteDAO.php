<?php

namespace App\DAO;

use App\DTOs\Note\Create\CreateNoteDTO;
use App\DTOs\Note\Update\UpdateNoteDTO;
use App\Models\Note;

class NoteDAO
{
    public function index($model)
    {
        return $model->notes;
    }

    public function OrderNotes(int $order_id, int $perPage = 15)
    {
        return Note::query()
            ->where('model_type', 'order')
            ->where('model_id', $order_id)
            ->latest()
            ->paginate($perPage);
    }

    public function show(int $id)
    {
        return Note::query()->where('id', $id)->first();
    }

    public function store($model, CreateNoteDTO $dto)
    {
        return $model->notes->create($dto->toArray());
    }

    public function update(int $id, UpdateNoteDTO $dto)
    {
        $note = $this->show($id);
        $note->update($dto->toArray());
        return $note->refresh();
    }

    public function destroy(int $id)
    {
        $note = $this->show($id);
        return $note->delete();
    }
}
