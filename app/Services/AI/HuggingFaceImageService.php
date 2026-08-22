<?php

namespace App\Services\AI;

use App\DAO\Engineer\ApartmentDesignSuggestionDAO;
use App\DTOs\RealEstate\Create\GenerateApartmentDesignDTO;
use App\DTOs\RealEstate\Create\GenerateApartmentDesignFromImageDTO;
use App\Models\ApartmentDesignSuggestion;
use App\Services\FileManagerService;
use App\Services\TranslationService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class HuggingFaceImageService
{
    protected string $modelUrl = 'https://router.huggingface.co/hf-inference/models/ByteDance/SDXL-Lightning';

    public function __construct(
        protected ApartmentDesignSuggestionDAO $designSuggestionDAO,
        private TranslationService $translation,
        protected FileManagerService $fileManagerService,
    ) {}

    public function generateAndSave(GenerateApartmentDesignDTO $dto): array
    {
        $analysis = $this->translation->generatePromptAndDetails($dto->prompt);
        $englishPrompt = $analysis['image_prompt'] ?? $dto->prompt;

        $encodedPrompt = rawurlencode($englishPrompt);
        $imageUrlApi = "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=1024&height=1024&seed=" . rand(1, 99999) . "&nologo=true&model=flux";

        $response = Http::timeout(60)->get($imageUrlApi);

        if (! $response->successful()) {
            throw new Exception("AI Image Generation Failed with status: " . $response->status());
        }

        $fileName = 'ai_designs/design_' . Str::random(12) . '.png';
        Storage::disk('s3')->put($fileName, $response->body(), 'public');
        $s3ImageUrl = Storage::disk('s3')->url($fileName);

        $suggestion = $this->designSuggestionDAO->create([
            'employee_id'          => $dto->employeeId,
            'building_id'          => $dto->buildingId,
            'apartment_number'     => $dto->apartmentNumber,
            'prompt'               => $dto->prompt,
            'style'                => $dto->style,
            'generated_image_urls' => [$s3ImageUrl],
        ]);

        return [
            'suggestion'       => $suggestion,
            'image_url'        => $s3ImageUrl,
            'layout_breakdown' => $analysis['layout_breakdown'] ?? [],
        ];
    }

    protected function pollReplicateResult(?string $getUrl, string $token): string
    {
        if (! $getUrl) {
            throw new Exception("Invalid Replicate status URL.");
        }

        for ($i = 0; $i < 30; $i++) {
            sleep(2);
            $res = Http::withToken($token)->get($getUrl)->json();

            if (($res['status'] ?? '') === 'succeeded') {
                return is_array($res['output']) ? $res['output'][0] : $res['output'];
            }

            if (($res['status'] ?? '') === 'failed') {
                throw new Exception("Replicate Processing Failed: " . ($res['error'] ?? 'Unknown'));
            }
        }

        throw new Exception("Replicate processing timed out.");
    }

    public function generateFromHuggingFace(string $englishPrompt): string
    {
        $apiKey = env('HUGGINGFACE_API_KEY');

        $modelUrl = "https://api-inference.huggingface.co/models/ZB-Tech/Text-to-Image";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type'  => 'application/json',
        ])->timeout(60)->post($modelUrl, [
            'inputs' => $englishPrompt,
        ]);

        if (! $response->successful()) {
            throw new Exception("Hugging Face API Error: " . $response->body());
        }

        return $response->body();
    }

    // public function generateFromExistingImage(GenerateApartmentDesignFromImageDTO $dto): ApartmentDesignSuggestion
    // {
    //     $replicateToken = config('services.replicate.api_token');

    //     if (empty($replicateToken)) {
    //         throw new Exception("Replicate API token is missing in configuration.");
    //     }

    //     $suggestion = $this->designSuggestionDAO->create([
    //         'employee_id'      => $dto->employeeId,
    //         'building_id'      => $dto->buildingId,
    //         'apartment_number' => $dto->apartmentNumber,
    //         'prompt'           => $dto->prompt,
    //         'style'            => $dto->style,
    //     ]);

    //     $storedAttachments = $this->fileManagerService->storeFile(
    //         model: $suggestion,
    //         files: $dto->imageFile,
    //         folderPath: 'ai_designs/originals',
    //         relationName: 'attachments'
    //     );

    //     $originalImageUrl = $storedAttachments[0]->url ?? null;

    //     if (! $originalImageUrl) {
    //         throw new Exception("Failed to process original image URL.");
    //     }

    //     $englishPrompt = $this->translation->translateToEnglishPrompt($dto->prompt);
    //     $fullPrompt = "Professional interior design render of this room, style: {$dto->style}, {$englishPrompt}, fully furnished, realistic lighting, 8k";

    //     $response = Http::withToken($replicateToken)
    //         ->timeout(60)
    //         ->post('https://api.replicate.com/v1/predictions', [
    //             'version' => '683d19dc312f7a9f0428b04429a9ccefd28dbf7785fef083ad5cf991b65f406f',
    //             'input'   => [
    //                 'image'               => $originalImageUrl,
    //                 'prompt'              => $fullPrompt,
    //                 'prompt_strength'     => 0.45,
    //                 'num_inference_steps' => 4,
    //             ]
    //         ]);

    //     if (! $response->successful()) {
    //         throw new Exception("Replicate API Error: " . $response->body());
    //     }

    //     $outputUrl = $this->pollReplicateResult($response->json('urls.get'), $replicateToken);

    //     $suggestion->update([
    //         'generated_image_urls' => [$outputUrl],
    //     ]);

    //     return $suggestion;
    // }

    public function generateFromExistingImage(GenerateApartmentDesignFromImageDTO $dto): ApartmentDesignSuggestion
    {
        $falKey = config('services.fal.api_key');

        if (empty($falKey)) {
            throw new Exception("Fal.ai API token is missing in configuration.");
        }

        $suggestion = $this->designSuggestionDAO->create([
            'uuid'         => (string) \Illuminate\Support\Str::uuid(),
            'employee_id'  => $dto->employeeId,
            'unit_id'      => $dto->unitId,
            'user_prompt'  => $dto->prompt,
            'design_style' => $dto->style,
        ]);

        $this->fileManagerService->storeFile(
            model: $suggestion,
            files: $dto->imageFile,
            folderPath: 'ai_designs/originals',
            relationName: 'attachments'
        );

        $base64Image = 'data:' . $dto->imageFile->getMimeType() . ';base64,' . base64_encode(file_get_contents($dto->imageFile->getRealPath()));

        try {
            $englishPrompt = $this->translation->translateToEnglishPrompt($dto->prompt);
        } catch (\Exception $e) {
            $englishPrompt = $dto->prompt;
        }

        $fullPrompt = "Professional architectural photography of an interior room, {$dto->style} style. {$englishPrompt}. Highly detailed, realistic lighting, beautiful furnished interior.\nstrictly preserve the original room structure, windows, and walls.";

        $response = Http::withHeaders([
            'Authorization' => "Key {$falKey}",
            'Content-Type'  => 'application/json',
        ])->timeout(180)->post('https://fal.run/fal-ai/flux-control-lora-depth', [
            'prompt'                 => $fullPrompt,
            'control_lora_image_url' => $base64Image,
            'conditioning_scale'     => 1.0,
            'num_inference_steps'    => 28,
            'guidance_scale'         => 3.0,
        ]);

        if (! $response->successful()) {
            throw new Exception("Fal.ai API Error: " . $response->body());
        }

        $outputUrl = $response->json('images.0.url');

        if (!$outputUrl) {
            throw new Exception("Fal.ai returned an invalid response structure.");
        }

        $imageBinary = Http::get($outputUrl)->body();
        $generatedFileName = 'ai_designs/redesign_' . Str::random(12) . '.png';

        Storage::disk(config('filesystems.default', 's3'))->put($generatedFileName, $imageBinary, 'public');
        $generatedS3Url = Storage::disk(config('filesystems.default', 's3'))->url($generatedFileName);

        $suggestion->update([
            'generated_image_urls' => [$generatedS3Url],
        ]);

        return $suggestion;
    }

    public function togglePublish(int $id)
    {
        $suggestion = $this->designSuggestionDAO->findById($id);

        $suggestion->update([
            'is_published' => !$suggestion->is_published
        ]);

        return $suggestion;
    }
}
