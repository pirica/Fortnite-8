<div class="page-container container-fn">
    <?php
    $title = '🎮 Notícias Battle Royale';
    $subtitle = $lastUpdate ? 'Última atualização: ' . date('d/m/Y H:i', strtotime($lastUpdate)) : null;
    include __DIR__ . '/../partials/page-header.php';
    ?>
    
    <?php if (empty($news)): ?>
    <?php
    $icon = '🎮';
    $title = 'Nenhuma notícia disponível';
    $message = ' '; 
    $actions = '<a href="' . htmlspecialchars($baseUrl) . '/news" class="btn-fn">Ver todas as notícias</a>';
    $variant = 'default';
    $size = 'default';
    include __DIR__ . '/../partials/state-card.php';
    ?>
    <?php else: ?>
    
    <!-- Featured News (first item) -->
    <?php $featured = array_shift($news); ?>
    <div class="feature-card featured-panel">
        <div class="content-grid content-grid--two featured-panel__frame">
            <?php if (!empty($featured['image'])): ?>
            <img src="<?= htmlspecialchars($featured['image']) ?>" 
                 alt="<?= htmlspecialchars($featured['title'] ?? '') ?>"
                 class="media-cover">
            <?php endif; ?>
            <div class="featured-panel__content">
                <span class="featured-badge">
                    🔥 DESTAQUE
                </span>
                <h2 class="featured-panel__title"><?= htmlspecialchars($featured['title'] ?? 'Sem título') ?></h2>
                <p class="featured-panel__text">
                    <?= htmlspecialchars($featured['body'] ?? '') ?>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Other News -->
    <div class="items-grid section-wide-grid">
        <?php foreach ($news as $index => $item): 
            $imageUrl = $item['tileImage'] ?? $item['image'] ?? '';
            $priority = $item['sortingPriority'] ?? 0;
            $newsClasses = $priority >= 5 ? 'news-card--hot' : '';
            $newsTitle = $item['title'] ?? 'Sem título';
            $newsBody = htmlspecialchars((string) ($item['body'] ?? ''));
            $newsImageUrl = $imageUrl;
            $newsBadgeLeft = '';
            $newsBadgeRight = $priority >= 5 ? '<span class="news-badge--hot">🔥 HOT</span>' : '';
            $newsDelay = $index * 0.05 . 's';
            include __DIR__ . '/../partials/news-card.php';
        ?>
        <?php endforeach; ?>
    </div>
    
    <?php endif; ?>
    
    <div class="section-actions-center">
        <a href="<?= $baseUrl ?>/news" class="btn-fn btn-fn-outline">← Ver todas as notícias</a>
    </div>
</div>
