<?php

namespace App\Http\Controllers\V1\Client;

use App\DTOs\Client\Create\CreateClientDTO;
use App\DTOs\User\Create\CreateUserDTO;
use App\DTOs\Client\Update\UpdateClientDTO;
use App\DTOs\User\Update\UpdateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Client\ClientRequest;
use App\Http\Resources\V1\ClientDetailResource;
use App\Models\Client\Client;
use App\Services\AIService;
use App\Services\Client\ClientService;
use App\Traits\ProvidesUserResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use ResponseTrait, ProvidesUserResource;

    public function __construct(
        private ClientService $clientService
    ) {}

    public function index()
    {
        $clients = $this->clientService->index();
        return $this->successUserCollection($clients);
    }

    public function store(ClientRequest $clientRequest)
    {
        $userDTO = CreateUserDTO::fromRequest($clientRequest->validated(), 'client');

        $clientDTO = CreateClientDTO::fromRequest($clientRequest->validated());

        $data = $this->clientService->store($userDTO, $clientDTO);

        # For Testing
        $data['client'] = $this->resolveUserResource($data['client']->user);

        return $this->successResponse($data, __('messages.auth.otp_sent'), 201);

        // return $this->useResource($data, ClientDetailResource::class, __('messages.auth.otp_sent'), 201);
    }

    public function show(int $id)
    {
        $client = $this->clientService->show($id);
        return $this->useResource($client, ClientDetailResource::class);
    }

    public function profile()
    {
        $client = $this->clientService->profile();
        return $this->useResource($client, ClientDetailResource::class);
    }

    public function update(Request $request)
    {
        $userDTO = UpdateUserDTO::fromRequest($request->all());

        $clientDTO = UpdateClientDTO::fromRequest($request->all());

        $client = $this->clientService->update($request->user()->client->id, $userDTO, $clientDTO);

        return $this->useResource($client, ClientDetailResource::class, __('messages.common.updated'));
    }

    public function destroy(int $id)
    {
        $this->clientService->destroy($id);
        return $this->successResponse([], __('messages.common.deleted'));
    }


    public function generatePlan(Request $request, $id, AIService $aiService)
    {
        $client = Client::findOrFail($id);

        // 1. استدعاء الخدمة
        // لنفرض أننا نمرر المساحة وعدد الغرف من الداتابيز أو الريكويست
        $suggestion = $aiService->suggestLayout(
            $request->input('area'),
            $request->input('rooms_count')
        );

        // 2. حفظ النتيجة في المودل
        $client->update([
            'ai_layout_suggestion' => $suggestion,
            'last_ai_prompt' => "Area: {$request->area}, Rooms: {$request->rooms_count}"
        ]);

        return response()->json([
            'message' => 'AI Plan generated successfully!',
            'suggestion' => $suggestion
        ]);
    }
}
