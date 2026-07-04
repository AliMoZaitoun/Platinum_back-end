<?php

namespace App\Http\Controllers\V1;

use App\DTOs\Note\Update\UpdateNoteDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\UpdateNoteRequest;
use App\Services\NoteService;
use App\Traits\ResponseTrait;

class NoteController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private NoteService $noteService
    ) {}

    public function update(int $id, UpdateNoteRequest $request)
    {
        $dto = UpdateNoteDTO::fromRequest($request->validated());
        $note = $this->noteService->update($id, $dto);
        return $this->successResponse([], __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->noteService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }
}
