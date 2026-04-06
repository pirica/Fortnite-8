<?php

declare(strict_types=1);

namespace FortniteHub\Models;

use FortniteHub\Core\ApiResult;
use FortniteHub\Services\FortniteApiClient;

/**
 * Fortnite API Model
 * 
 * Handles all communication with the Fortnite API
 * 
 * @package FortniteHub\Models
 */
class FortniteAPI
{
    private FortniteApiClient $client;

    /**
     * Initialize API configuration
     */
    public function __construct()
    {
        $this->client = new FortniteApiClient();
    }

    /**
     * Get shop items
     * 
     * @return array<string, mixed>|null
     */
    public function getShop(): ?array
    {
        return $this->normalize($this->client->getShop());
    }

    /**
     * Get news
     * 
     * @return array<string, mixed>|null
     */
    public function getNews(): ?array
    {
        return $this->normalize($this->client->getNews());
    }

    /**
     * Get Battle Royale news
     * 
     * @return array<string, mixed>|null
     */
    public function getNewsBR(): ?array
    {
        return $this->normalize($this->client->getNewsBR());
    }

    /**
     * Get Save the World news
     * 
     * @return array<string, mixed>|null
     */
    public function getNewsSTW(): ?array
    {
        return $this->normalize($this->client->getNewsSTW());
    }

    /**
     * Search cosmetics by name
     * 
     * @return array<string, mixed>|null
     */
    public function searchCosmetics(string $query): ?array
    {
        return $this->normalize($this->client->searchCosmetics($query));
    }

    /**
     * Get cosmetic by ID
     * 
     * @return array<string, mixed>|null
     */
    public function getCosmetic(string $id): ?array
    {
        return $this->normalize($this->client->getCosmetic($id));
    }

    /**
     * Search cosmetic by exact name
     * 
     * @return array<string, mixed>|null
     */
    public function getCosmeticByName(string $name): ?array
    {
        return $this->normalize($this->client->getCosmeticByName($name));
    }

    /**
     * Get player stats
     * 
     * @return array<string, mixed>|null
     */
    public function getPlayerStats(string $name, string $platform = 'epic'): ?array
    {
        return $this->normalize($this->client->getPlayerStats($name, $platform));
    }

    /**
     * Get playlists
     * 
     * @return array<string, mixed>|null
     */
    public function getPlaylists(): ?array
    {
        return $this->normalize($this->client->getPlaylists());
    }

    /**
     * @return array<string, mixed>
     */
    private function normalize(ApiResult $result): array
    {
        if ($result->ok && is_array($result->payload)) {
            return $result->payload;
        }

        return [
            'status' => $result->statusCode,
            'error' => $result->errorMessage ?? 'Não foi possível obter dados no momento.',
            'error_type' => $result->errorType ?? 'unknown',
            'data' => [],
        ];
    }
}
