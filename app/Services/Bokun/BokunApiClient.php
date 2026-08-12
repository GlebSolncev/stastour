<?php

namespace App\Services\Bokun;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class BokunApiClient
{
    private string $baseUrl;
    private string $accessKey;
    private string $secretKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.bokun.url'), '/');
        $this->accessKey = config('services.bokun.access_key');
        $this->secretKey = config('services.bokun.secret_key');
    }

    /**
     * Системный метод отправки запросов для REST v1
     */
    public function request(string $method, string $endpoint, array $options = []): array
    {
        $method = strtoupper($method);

        // 1. Текущая дата в UTC, формат строго "yyyy-MM-dd HH:mm:ss"
        $date = gmdate('Y-m-d H:i:s');

        // 2. Сборка пути. По доке: path (including query string), но БЕЗ схемы и хоста.
        $pathWithQuery = '/' . ltrim($endpoint, '/');
        if ($method === 'GET' && !empty($options)) {
            // Сортируем параметры для консистентности сигнатуры
            ksort($options);
            $pathWithQuery .= '?' . http_build_query($options, '', '&', PHP_QUERY_RFC3986);
        }

        // 3. Склеивание строки подписи: X-Bokun-Date + AccessKey + Method + PathWithQuery
        $signatureInput = $date . $this->accessKey . $method . $pathWithQuery;

        // 4. Подпись секретным ключом с использованием алгоритма HmacSHA1 (согласно доке)
        // Передаем true для генерации сырых бинарных данных, затем кодируем в Base64
        $rawHash = hash_hmac('sha1', $signatureInput, $this->secretKey, true);
        $signature = base64_encode($rawHash);

        try {
            $headers = [
                'Content-Type'      => 'application/json; charset=utf-8',
                'Accept'            => 'application/json',
                'X-Bokun-Date'      => $date,
                'X-Bokun-AccessKey' => $this->accessKey,
                'X-Bokun-Signature' => $signature,
            ];

            $url = "{$this->baseUrl}" . $pathWithQuery;


            // Выполняем HTTP запрос через Laravel Client
            $response = $method === 'POST'
                ? Http::withHeaders($headers)->timeout(15)->post("{$this->baseUrl}/" . ltrim($endpoint, '/'), $options)
                : Http::withHeaders($headers)->timeout(15)->get($url); // Для GET параметры уже встроены в $url

            if ($response->failed()) {
                Log::error("Bokun API request failed", [
                    'path'   => $pathWithQuery,
                    'status' => $response->status(),
                    'body'   => $response->body()
                ]);
                throw new Exception($response->body());
            }

            return $response->json();

        } catch (Exception $e) {
            Log::critical("Bokun Connection Exception", [
                'message' => $e->getMessage(),
                'path'    => $pathWithQuery
            ]);
            throw $e;
        }
    }
}