<?php

namespace App\Http\Controllers\V1\Engineer;

use App\DTOs\RealEstate\Create\GenerateApartmentDesignDTO;
use App\DTOs\RealEstate\Create\GenerateApartmentDesignFromImageDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Engineer\GenerateDesignFromImageRequest;
use App\Http\Requests\V1\Engineer\GenerateDesignImageRequest;
use App\Http\Resources\V1\Engineer\ApartmentDesignSuggestionResource;
use App\Services\AI\HuggingFaceImageService;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class ApartmentDesignAiController extends Controller
{
    use ResponseTrait;
    public function __construct(
        protected HuggingFaceImageService $aiImageService
    ) {}

    public function generate(GenerateDesignImageRequest $request)
    {
        $dto = GenerateApartmentDesignDTO::fromRequest($request);

        $result = $this->aiImageService->generateAndSave($dto);

        return response()->json([
            'status'   => true,
            'message'  => __('messages.common.stored'),
            'data'     => new ApartmentDesignSuggestionResource($result['suggestion']),
            'details'  => $result['layout_breakdown'],
        ]);
    }

    public function generateFromImage(GenerateDesignFromImageRequest $request): ApartmentDesignSuggestionResource
    {
        $dto = GenerateApartmentDesignFromImageDTO::fromRequest($request);

        $suggestion = $this->aiImageService->generateFromExistingImage($dto);

        return new ApartmentDesignSuggestionResource($suggestion);
    }
}
