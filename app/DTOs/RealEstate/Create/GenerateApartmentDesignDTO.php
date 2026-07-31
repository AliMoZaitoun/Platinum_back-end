<?php

namespace App\DTOs\RealEstate\Create;

use App\Http\Requests\V1\Engineer\GenerateDesignImageRequest;

class GenerateApartmentDesignDTO
{
    public function __construct(
        public readonly int $employeeId,
        public readonly ?int $buildingId,
        public readonly ?string $apartmentNumber,
        public readonly string $prompt,
        public readonly string $style
    ) {}

    public static function fromRequest(GenerateDesignImageRequest $request): self
    {
        $validated = $request->validated();
        $user = $request->user();

        return new self(
            employeeId: $user->employee->id ?? $user->id,
            buildingId: $validated['building_id'] ?? null,
            apartmentNumber: $validated['apartment_number'] ?? null,
            prompt: $validated['prompt'],
            style: $validated['style'] ?? 'modern'
        );
    }

    public function toArray(): array
    {
        return [
            'employee_id'      => $this->employeeId,
            'building_id'      => $this->buildingId,
            'apartment_number' => $this->apartmentNumber,
            'user_prompt'      => $this->prompt,
            'design_style'     => $this->style,
        ];
    }
}
