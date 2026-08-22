<?php

namespace App\DTOs\RealEstate\Create;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class GenerateApartmentDesignFromImageDTO
{
    public function __construct(
        public int $employeeId,
        public int $unitId,
        public string $style,
        public string $prompt,
        public UploadedFile $imageFile
    ) {}

    public static function fromRequest($request): self
    {
        return new self(
            employeeId: Auth::user()->employee->id ?? 1,
            unitId: (int) $request->unit_id,
            style: $request->style ?? 'Modern',
            prompt: (string) $request->prompt,
            imageFile: $request->file('image')
        );
    }
}
