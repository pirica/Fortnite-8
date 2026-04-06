<?php

declare(strict_types=1);

namespace FortniteHub\Controllers;

use FortniteHub\Core\Controller;
use FortniteHub\Models\FortniteAPI;

/**
 * Player Controller
 * 
 * @package FortniteHub\Controllers
 */
class PlayerController extends Controller
{
    /** @var FortniteAPI */
    private FortniteAPI $api;

    public function __construct()
    {
        $this->api = new FortniteAPI();
        $this->pageTitle = 'Buscar Jogador - Fortnite Hub';
    }

    /**
     * Display player search page
     */
    public function search(): void
    {
        $playerName = trim((string) $this->getQuery('player', ''));
        $platform = strtolower(trim((string) $this->getQuery('platform', 'epic')));
        $allowedPlatforms = ['epic', 'psn', 'xbl'];

        if (!in_array($platform, $allowedPlatforms, true)) {
            $platform = 'epic';
        }
        
        $playerData = null;
        $error = null;

        if ($playerName) {
            $result = $this->api->getPlayerStats($playerName, $platform);
            
            if ($result && $result['status'] === 200) {
                $playerData = $result['data'];
                $this->pageTitle = ($playerData['account']['name'] ?? $playerName) . ' - Fortnite Hub';
            } else {
                $error = $result['error'] ?? 'Jogador não encontrado ou perfil privado.';
            }
        }

        $this->view('player/search', [
            'playerName' => $playerName,
            'platform' => $platform,
            'playerData' => $playerData,
            'error' => $error,
        ]);
    }

    /**
     * Display player stats (alias for search with name param)
     */
    public function stats(string $name): void
    {
        $_GET['player'] = $name;
        $this->search();
    }
}
