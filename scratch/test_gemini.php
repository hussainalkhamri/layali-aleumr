<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\GeminiService;

$service = new GeminiService();
$response = $service->generateResponse("Hello, tell me a very short joke in Arabic.");

echo "Response from Gemini: " . $response . "\n";
