<?php

namespace App\Http\Controllers\V1\Finance;

use App\DTOs\Finance\Create\ReviewContractExceptionDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Finance\ReviewContractExceptionRequest;
use App\Http\Resources\V1\Finance\ContractExceptionResource;
use App\Services\Finance\ContractExceptionService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class ContractExceptionController extends Controller
{
    use ResponseTrait;

    public function __construct(
        private ContractExceptionService $service
    ) {}

    public function index()
    {
        $exceptions = $this->service->index();
        return $this->successCollection($exceptions, ContractExceptionResource::class);
    }

    public function show(int $id)
    {
        $exception = $this->service->show($id);
        return $this->useResource($exception, ContractExceptionResource::class);
    }

    public function review(int $id, ReviewContractExceptionRequest $request)
    {
        $employee = Auth::user()->employee;
        $dto = ReviewContractExceptionDTO::fromRequest($request, $id, $employee->id);

        $exception = $this->service->review($id, $dto);

        return $this->useResource(
            $exception,
            ContractExceptionResource::class,
            __('messages.common.updated')
        );
    }
}
