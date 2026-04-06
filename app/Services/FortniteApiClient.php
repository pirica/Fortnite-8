<?php

declare(strict_types=1);

namespace FortniteHub\Services;

use FortniteHub\Core\ApiResult;
use FortniteHub\Core\Cache;
use FortniteHub\Core\Config;
use FortniteHub\Core\HttpClient;

/**
 * Service layer for Fortnite API communication.
 */
final class FortniteApiClient
{
    private HttpClient $http;
    private Cache $cache;
    private string $apiUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->http = new HttpClient();
        $this->cache = new Cache();
        $this->apiUrl = (string) Config::get('api.fortnite_url', 'https://fortnite-api.com/v2/');
        $this->apiKey = (string) Config::get('api.fortnite_key', '');
    }

    public function getShop(): ApiResult
    {
        return $this->request('shop', true, 600);
    }

    public function getNews(): ApiResult
    {
        return $this->request('news', true, 300);
    }

    public function getNewsBR(): ApiResult
    {
        return $this->request('news/br', true, 300);
    }

    public function getNewsSTW(): ApiResult
    {
        return $this->request('news/stw', true, 300);
    }

    public function searchCosmetics(string $query): ApiResult
    {
        return $this->request('cosmetics/br/search/all?name=' . urlencode($query) . '&matchMethod=contains', true, 600);
    }

    public function getCosmetic(string $id): ApiResult
    {
        return $this->request('cosmetics/br/' . rawurlencode($id), true, 3600);
    }

    public function getCosmeticByName(string $name): ApiResult
    {
        return $this->request('cosmetics/br/search?name=' . urlencode($name), true, 3600);
    }

    public function getPlayerStats(string $name, string $platform = 'epic'): ApiResult
    {
        return $this->request('stats/br/v2?name=' . urlencode($name) . '&accountType=' . urlencode($platform), true, 300);
    }

    public function getPlaylists(): ApiResult
    {
        // This endpoint is currently in v1.
        return $this->request('../v1/playlists', true, 3600);
    }

    private function request(string $endpoint, bool $useCache, int $cacheTtl): ApiResult
    {
        $cacheKey = 'api_' . md5($endpoint);

        if ($useCache) {
            $cached = $this->cache->get($cacheKey);
            if (is_array($cached)) {
                return ApiResult::success($cached, 200);
            }
        }

        $headers = [];
        if ($this->apiKey !== '') {
            $headers[] = 'Authorization: ' . $this->apiKey;
        }

        $url = rtrim($this->apiUrl, '/') . '/' . ltrim($endpoint, '/');
        $result = $this->http->getJson($url, $headers, 30);

        if (!$result->ok) {
            return $result;
        }

        $payload = $result->payload;
        if (!is_array($payload)) {
            return ApiResult::error('invalid_payload', 'Resposta vazia ou inválida da API.', $result->statusCode);
        }

        $fortniteStatus = (int) ($payload['status'] ?? 0);
        if ($fortniteStatus !== 200) {
            $errorMessage = (string) ($payload['error'] ?? $payload['message'] ?? 'Falha ao consultar a API do Fortnite.');
            return ApiResult::error('api_error', $errorMessage, $fortniteStatus > 0 ? $fortniteStatus : $result->statusCode);
        }

        if ($useCache) {
            $this->cache->set($cacheKey, $payload, $cacheTtl);
        }

        return ApiResult::success($payload, $fortniteStatus);
    }
}
