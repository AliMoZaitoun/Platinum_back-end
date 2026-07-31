<?php

namespace App\DTOs\RealEstate\Create;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class GenerateApartmentDesignFromImageDTO
{
    public function __construct(
        public int $employeeId,
        public int $buildingId,
        public string $apartmentNumber,
        public string $style,
        public string $prompt,
        public UploadedFile $imageFile
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            employeeId: Auth::user()->employee->id ?? 1,
            buildingId: (int) $request->building_id,
            apartmentNumber: (string) $request->apartment_number,
            style: $request->style ?? 'Modern',
            prompt: (string) $request->prompt,
            imageFile: $request->file('image')
        );
    }
}
