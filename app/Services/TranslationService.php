<?php

namespace App\Services;

use Gemini;

class TranslationService
{
    protected $client;

    public function __construct()
    {
        $apiKey = config('services.gemini.key');
        $this->client = Gemini::client($apiKey);
    }

    public function translateAll(string $text): array
    {
        $modelName = 'gemini-2.5-flash';

        $result = $this->client
            ->generativeModel($modelName)
            ->generateContent($this->buildPrompt($text));

        $aiText = $result->text();
        return json_decode($aiText, true) ?? ['ar' => $text];
    }

    private function buildPrompt(string $text): string
    {
        $targetLanguages = ['ar', 'en'];

        $prompt = "You are an expert real estate and architecture translator. 
                   Translate the following text into these languages: " . implode(', ', $targetLanguages) . ". 
                   Respond ONLY with a valid JSON object where keys are the language codes and values are the translations.
                   Do not include any markdown formatting or markdown code blocks (like ```json).
                   Text to translate: \"{$text}\"";

        return $prompt;
    }

    public function translateToEnglishPrompt(string $text): string
    {
        $modelName = 'gemini-2.5-flash';

        $prompt = "You are an expert real estate and architectural prompt engineer.
               Analyze the user input and convert it into a highly effective English prompt for 3D AI image generation:

               - If the input is about a floor plan / apartment partitioning (e.g. rooms, area in sqm, balcony, layout):
                 Create a prompt for a 'Clean top-down 3D architectural floor plan cutaway, orthographic view, clear wall partitions, well-defined room spaces, minimal furniture, bright high-end architectural model style'.

               - If the input is about interior decorating a specific room (e.g. living room design):
                 Create a prompt for a 'Photorealistic 3D interior design render, eye-level perspective, detailed materials, architectural lighting'.

               Do not include any intro, explanation, markdown, or JSON. Return ONLY the optimized English prompt string.
               User Input: \"{$text}\"";

        $result = $this->client
            ->generativeModel($modelName)
            ->generateContent($prompt);

        return trim($result->text());
    }

    public function generatePromptAndDetails(string $text): array
    {
        $modelName = 'gemini-2.5-flash';

        $prompt = "You are an expert real estate prompt engineer.
               Analyze the user text for apartment partitioning: \"{$text}\"

               Respond ONLY with a valid JSON object (no markdown, no backticks) containing:
               1. \"image_prompt\": Create a precise English prompt for a 3D Floor plan using this exact structure:
                  'Isometric 3D cutaway floor plan render of an apartment, high angle top view, showing distinct partitioned rooms: [extract requested rooms like 2 bedrooms, living room, kitchen, bathroom, balcony], clean white walls, minimalist wooden floor, clearly visible wall boundaries, neat spatial distribution, architectural model style, bright soft natural daylight, rendered in V-Ray, highly detailed, clean lines'.

               2. \"layout_breakdown\": An object containing:
                  - \"total_area\": Estimated area.
                  - \"rooms\": Array of objects with \"name\", \"estimated_area\", and \"description\".
                  - \"architectural_notes\": Brief note in Arabic.
               ";

        $result = $this->client
            ->generativeModel($modelName)
            ->generateContent($prompt);

        $cleanJson = trim(str_replace(['```json', '```'], '', $result->text()));

        return json_decode($cleanJson, true) ?? [
            'image_prompt' => $text,
            'layout_breakdown' => []
        ];
    }
}
