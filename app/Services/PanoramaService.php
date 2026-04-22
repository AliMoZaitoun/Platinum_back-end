<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SkyboxService
{
    public function generate(string $prompt)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Key ' . config('services.fal.key'),
            'Content-Type' => 'application/json',
        ])->post('https://fal.run/fal-ai/stable-diffusion-v15-panorama', [
            'prompt' => $prompt . ", 360 degree panoramic view, equirectangular projection",
        ]);

        return $response->json(); // سيعطيك رابط الصورة فوراً دون انتظار طويل
    }
}
