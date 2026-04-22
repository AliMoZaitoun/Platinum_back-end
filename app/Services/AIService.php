<?php

namespace App\Services;

use Gemini;
use Illuminate\Support\Facades\Http;

class AIService
{
    protected $client;

    public function __construct()
    {
        $apiKey = config('services.gemini.key');
        $this->client = Gemini::client($apiKey);
    }

    public function suggestLayout($area, $rooms)
    {

        $modelName = 'gemini-2.5-flash';

        $prompt = "أنت مهندس معماري. أعطني تقسيماً لشقة مساحتها {$area} م2 بـ {$rooms} غرف. 
               الرد يجب أن يكون بصيغة JSON فقط كالتالي:
               {
                 'rooms': [{'name': 'string', 'size': 'string'}],
                 'total_estimated_cost': 'string',
                 'design_style': 'string'
               }
               ملاحظة: لا تكتب أي نص قبل أو بعد الـ JSON.";

        $result = $this->client
            ->generativeModel($modelName)
            ->generateContent($prompt);

        $cleanJson = preg_replace('/^```json\s+|```$/', '', $result->text());

        return json_decode($cleanJson, true);
    }

    public function listModels()
    {
        $response = $this->client->models()->list();
        return $response;
        foreach ($response->models as $model) {
            dump($model->name);
        }
    }
}
