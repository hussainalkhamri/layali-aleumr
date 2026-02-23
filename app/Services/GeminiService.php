<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
    }

    public function generateResponse(string $prompt): ?string
    {
        if (empty($this->apiKey)) {
            Log::error('Gemini API key is missing.');
            return 'خطأ: مفتاح API غير متوفر.';
        }

        try {
            $response = Http::post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'لم يتم استلام رد من الذكاء الاصطناعي.';
            }

            $errorBody = $response->json();
            $errorMessage = $errorBody['error']['message'] ?? 'Unknown error';
            
            Log::error('Gemini API Error: ' . $response->body());

            if (str_contains($errorMessage, 'quota') || $response->status() == 429) {
                return 'عذراً، تم تجاوز حصة الاستخدام المجانية لليوم. يرجى المحاولة لاحقاً أو الترقية لخطة مدفوعة.';
            }

            return 'حدث خطأ أثناء التواصل مع الذكاء الاصطناعي.';

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return 'حدث خطأ فني في خدمة الذكاء الاصطناعي.';
        }
    }
}
