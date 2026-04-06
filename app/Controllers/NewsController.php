<?php

declare(strict_types=1);

namespace FortniteHub\Controllers;

use FortniteHub\Core\Controller;
use FortniteHub\Models\FortniteAPI;

/**
 * News Controller
 * 
 * @package FortniteHub\Controllers
 */
class NewsController extends Controller
{
    /** @var FortniteAPI */
    private FortniteAPI $api;

    public function __construct()
    {
        $this->api = new FortniteAPI();
        $this->pageTitle = 'Notícias - Fortnite Hub';
    }

    /**
     * Display all news
     */
    public function index(): void
    {
        $newsData = $this->api->getNews();
        
        $brNews = [];
        $stwNews = [];
        $lastUpdate = '';
        $apiError = null;

        if ($newsData && $newsData['status'] === 200) {
            $lastUpdate = $newsData['data']['br']['date'] ?? '';
            
            // BR News
            if (!empty($newsData['data']['br']['motds'])) {
                $brNews = $newsData['data']['br']['motds'];
                usort($brNews, fn($a, $b) => ($b['sortingPriority'] ?? 0) - ($a['sortingPriority'] ?? 0));
            }
            
            // STW News
            if (!empty($newsData['data']['stw']['messages'])) {
                $stwNews = $newsData['data']['stw']['messages'];
            }
        } elseif (is_array($newsData)) {
            $apiError = $newsData['error'] ?? 'Não foi possível carregar as notícias no momento.';
        }

        $this->view('news/index', [
            'brNews' => $brNews,
            'stwNews' => $stwNews,
            'lastUpdate' => $lastUpdate,
            'apiError' => $apiError,
        ]);
    }

    /**
     * Display Battle Royale news
     */
    public function br(): void
    {
        $this->pageTitle = 'Notícias BR - Fortnite Hub';
        $newsData = $this->api->getNewsBR();
        
        $news = [];
        $lastUpdate = '';

        if ($newsData && $newsData['status'] === 200) {
            $lastUpdate = $newsData['data']['date'] ?? '';
            
            if (!empty($newsData['data']['motds'])) {
                $news = $newsData['data']['motds'];
                usort($news, fn($a, $b) => ($b['sortingPriority'] ?? 0) - ($a['sortingPriority'] ?? 0));
            }
        }

        $this->view('news/br', [
            'news' => $news,
            'lastUpdate' => $lastUpdate,
        ]);
    }

    /**
     * Display Save the World news
     */
    public function stw(): void
    {
        $this->pageTitle = 'Notícias STW - Fortnite Hub';
        $newsData = $this->api->getNewsSTW();
        
        $news = [];
        $lastUpdate = '';

        if ($newsData && $newsData['status'] === 200) {
            $lastUpdate = $newsData['data']['date'] ?? '';
            $news = $newsData['data']['messages'] ?? [];
        }

        $this->view('news/stw', [
            'news' => $news,
            'lastUpdate' => $lastUpdate,
        ]);
    }
}
