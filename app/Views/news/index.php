<div class="page-container container-fn">
    <?php
    $title = '📰 Notícias do Fortnite';
    $subtitle = $lastUpdate ? 'Última atualização: ' . date('d/m/Y H:i', strtotime($lastUpdate)) : null;
    include __DIR__ . '/../partials/page-header.php';
    ?>
    
    <!-- Tabs -->
    <div class="toolbar">
        <button class="btn-fn tab-btn is-active" onclick="showTab('all', this)">📋 Todas</button>
        <button class="btn-fn btn-fn-outline tab-btn" onclick="showTab('br', this)">🎮 Battle Royale</button>
        <button class="btn-fn btn-fn-outline tab-btn" onclick="showTab('stw', this)">⚔️ Salve o Mundo</button>
    </div>
    
    <!-- BR News -->
    <div id="tab-all" class="tab-content is-active">
        <?php if (!empty($apiError)): ?>
        <?php
        $icon = '🛰️';
        $title = 'Falha ao carregar notícias';
        $message = htmlspecialchars($apiError);
        $variant = 'default';
        $size = 'wide';
        include __DIR__ . '/../partials/state-card.php';
        ?>
        <?php else: ?>
        <div class="items-grid section-wide-grid">
            <?php 
            $allNews = array_merge(
                array_map(fn($n) => array_merge($n, ['source' => 'br']), $brNews),
                array_map(fn($n) => array_merge($n, ['source' => 'stw']), $stwNews)
            );
            usort($allNews, fn($a, $b) => ($b['sortingPriority'] ?? 0) - ($a['sortingPriority'] ?? 0));
            
            foreach ($allNews as $index => $news): 
                $imageUrl = $news['tileImage'] ?? $news['image'] ?? '';
                $priority = $news['sortingPriority'] ?? 0;
                $newsClasses = $priority >= 10 ? 'news-card--featured' : '';
                $newsTitle = $news['title'] ?? 'Sem título';
                $newsBody = htmlspecialchars(substr((string) ($news['body'] ?? ''), 0, 120)) . '...';
                $newsImageUrl = $imageUrl;
                $newsBadgeLeft = '<span class="news-badge--source ' . htmlspecialchars($news['source'] === 'br' ? 'news-badge--br' : 'news-badge--stw') . '">' . ($news['source'] === 'br' ? '🎮 BR' : '⚔️ STW') . '</span>';
                $newsBadgeRight = $priority >= 10 ? '<span class="news-badge--featured">⭐ DESTAQUE</span>' : '';
                $newsDelay = $index * 0.05 . 's';
                include __DIR__ . '/../partials/news-card.php';
            ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div id="tab-br" class="tab-content" hidden>
        <div class="items-grid section-wide-grid">
            <?php foreach ($brNews as $index => $news): 
                $imageUrl = $news['tileImage'] ?? $news['image'] ?? '';
                $newsTitle = $news['title'] ?? 'Sem título';
                $newsBody = htmlspecialchars((string) ($news['body'] ?? ''));
                $newsImageUrl = $imageUrl;
                $newsBadgeLeft = '';
                $newsBadgeRight = '';
                $newsClasses = '';
                $newsDelay = $index * 0.05 . 's';
                include __DIR__ . '/../partials/news-card.php';
            ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div id="tab-stw" class="tab-content" hidden>
        <?php if (empty($stwNews)): ?>
        <div class="tab-content__empty">
            <span class="tab-content__empty-icon">⚔️</span>
            <h3 class="tab-content__empty-title">Nenhuma notícia de Salve o Mundo</h3>
            <p class="tab-content__empty-text">Não há notícias disponíveis no momento.</p>
        </div>
        <?php else: ?>
        <div class="items-grid section-wide-grid">
            <?php foreach ($stwNews as $index => $news): 
                $imageUrl = $news['image'] ?? '';
                $newsTitle = $news['title'] ?? 'Sem título';
                $newsBody = htmlspecialchars((string) ($news['body'] ?? ''));
                if (!empty($news['adspace'])) {
                    $newsBody .= '<p class="news-card__body--notice">📢 ' . htmlspecialchars((string) $news['adspace']) . '</p>';
                }
                $newsImageUrl = $imageUrl;
                $newsBadgeLeft = '';
                $newsBadgeRight = '';
                $newsClasses = '';
                $newsDelay = $index * 0.05 . 's';
                include __DIR__ . '/../partials/news-card.php';
            ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
function showTab(tab, trigger) {
    document.querySelectorAll('.tab-content').forEach(el => el.hidden = true);
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('is-active');
        el.classList.add('btn-fn-outline');
    });
    
    const target = document.getElementById('tab-' + tab);
    target.hidden = false;
    target.classList.add('is-active');
    if (trigger) {
        trigger.classList.add('is-active');
        trigger.classList.remove('btn-fn-outline');
    }
}
</script>
