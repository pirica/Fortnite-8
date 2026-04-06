<div class="page-container container-fn">
    <?php
    $title = '📰 Notícias do Fortnite';
    $subtitle = $lastUpdate ? 'Última atualização: ' . date('d/m/Y H:i', strtotime($lastUpdate)) : null;
    include __DIR__ . '/../partials/page-header.php';
    ?>
    
    <!-- Tabs -->
    <div class="toolbar">
        <button class="btn-fn tab-btn active" onclick="showTab('all', this)">📋 Todas</button>
        <button class="btn-fn btn-fn-outline tab-btn" onclick="showTab('br', this)">🎮 Battle Royale</button>
        <button class="btn-fn btn-fn-outline tab-btn" onclick="showTab('stw', this)">⚔️ Salve o Mundo</button>
    </div>
    
    <!-- BR News -->
    <div id="tab-all" class="tab-content">
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
        <div class="items-grid" style="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));">
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
                $newsBadgeLeft = '<span style="background: ' . htmlspecialchars($news['source'] === 'br' ? 'var(--fn-blue)' : 'var(--fn-orange)') . '">' . ($news['source'] === 'br' ? '🎮 BR' : '⚔️ STW') . '</span>';
                $newsBadgeRight = $priority >= 10 ? '<span style="background: var(--fn-yellow); color: #000; font-weight: bold;">⭐ DESTAQUE</span>' : '';
                $newsDelay = $index * 0.05 . 's';
                include __DIR__ . '/../partials/news-card.php';
            ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    
    <div id="tab-br" class="tab-content" style="display: none;">
        <div class="items-grid" style="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));">
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
    
    <div id="tab-stw" class="tab-content" style="display: none;">
        <?php if (empty($stwNews)): ?>
        <div style="text-align: center; padding: 60px;">
            <span style="font-size: 4rem;">⚔️</span>
            <h3 style="margin: 20px 0;">Nenhuma notícia de Salve o Mundo</h3>
            <p style="color: var(--text-secondary);">Não há notícias disponíveis no momento.</p>
        </div>
        <?php else: ?>
        <div class="items-grid" style="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));">
            <?php foreach ($stwNews as $index => $news): 
                $imageUrl = $news['image'] ?? '';
                $newsTitle = $news['title'] ?? 'Sem título';
                $newsBody = htmlspecialchars((string) ($news['body'] ?? ''));
                if (!empty($news['adspace'])) {
                    $newsBody .= '<p style="color: var(--fn-yellow); font-size: 0.85rem; margin-top: 10px;">📢 ' . htmlspecialchars((string) $news['adspace']) . '</p>';
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

<style>
.news-card {
    position: relative;
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.tab-btn.active {
    background: var(--fn-purple) !important;
}
</style>

<script>
function showTab(tab, trigger) {
    document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('active');
        el.classList.add('btn-fn-outline');
    });
    
    document.getElementById('tab-' + tab).style.display = 'block';
    if (trigger) {
        trigger.classList.add('active');
        trigger.classList.remove('btn-fn-outline');
    }
}
</script>
