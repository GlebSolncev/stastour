<?php

namespace App\Services;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class BokunApiService
{
    protected $baseUrl;
    protected $accessKey;
    protected $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('services.bokun.url');
        $this->accessKey = config('services.bokun.access_key');
        $this->secretKey = config('services.bokun.secret_key');
    }

    // Вспомогательный метод для отправки запросов с заголовками авторизации
    protected function client(string $method, string $path)
    {
        // 1. Получаем текущую дату и время в UTC (формат: YYYY-MM-DD HH:mm:ss)
        $date = Carbon::now('UTC')->format('Y-m-d H:i:s');

        // 2. Формируем строку для подписи по правилам Bokun
        // Шаблон: DATE + ACCESS_KEY + HTTP_METHOD + PATH
        $signatureData = $date . $this->accessKey . strtoupper($method) . $path;

        // 3. Генерируем бинарный HMAC-SHA256 хэш и кодируем его в Base64
        $signature = base64_encode(hash_hmac('sha256', $signatureData, $this->secretKey, true));

        return Http::withHeaders([
            'X-Bokun-AccessKey' => $this->accessKey,
            'X-Bokun-Date'      => $date,
            'X-Bokun-Signature' => $signature,
            'Accept'            => 'application/json',
            'Content-Type'      => 'application/json',
        ])->baseUrl($this->baseUrl);

    }

    // 1. Получить все туры (Activity)
    public function getTours()
    {
        $path = '/activity.json/active-ids';

        $response = $this->client('GET', $path)->get($path);

        dd(
            $response->successful(),
            $response->body(),
        );

        return $response->successful() ? $response->json() : [];
    }

    // 2. Получить календарь, время и цены для конкретного тура
    public function getTourAvailability($tourId, $start, $end)
    {
        // Эндпоинт для проверки цен и доступности по датам
        $response = $this->client()->get("/activity.json/{$tourId}/availabilities", [
            'start' => $start, // формат YYYY-MM-DD
            'end' => $end
        ]);

        return $response->successful() ? $response->json() : [];
    }
}