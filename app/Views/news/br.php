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
    <div class="feature-card" style="margin-bottom: 50px; overflow: hidden;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; min-height: 300px;">
            <?php if (!empty($featured['image'])): ?>
            <img src="<?= htmlspecialchars($featured['image']) ?>" 
                 alt="<?= htmlspecialchars($featured['title'] ?? '') ?>"
                 style="width: 100%; height: 100%; object-fit: cover;">
            <?php endif; ?>
            <div style="padding: 30px; display: flex; flex-direction: column; justify-content: center;">
                <span style="background: var(--fn-yellow); color: #000; padding: 5px 12px; border-radius: 4px; font-size: 0.85rem; font-weight: bold; display: inline-block; width: fit-content; margin-bottom: 15px;">
                    🔥 DESTAQUE
                </span>
                <h2 style="margin-bottom: 15px;"><?= htmlspecialchars($featured['title'] ?? 'Sem título') ?></h2>
                <p style="color: var(--text-secondary); line-height: 1.6;">
                    <?= htmlspecialchars($featured['body'] ?? '') ?>
                </p>
            </div>
        </div>
    </div>
    
    <!-- Other News -->
    <div class="items-grid" style="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));">
        <?php foreach ($news as $index => $item): 
            $imageUrl = $item['tileImage'] ?? $item['image'] ?? '';
            $priority = $item['sortingPriority'] ?? 0;
            $newsClasses = $priority >= 5 ? 'news-card--hot' : '';
            $newsTitle = $item['title'] ?? 'Sem título';
            $newsBody = htmlspecialchars((string) ($item['body'] ?? ''));
            $newsImageUrl = $imageUrl;
            $newsBadgeLeft = '';
            $newsBadgeRight = $priority >= 5 ? '<span style="background: var(--fn-orange);">🔥 HOT</span>' : '';
            $newsDelay = $index * 0.05 . 's';
            include __DIR__ . '/../partials/news-card.php';
        ?>
        <?php endforeach; ?>
    </div>
    
    <?php endif; ?>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?= $baseUrl ?>/news" class="btn-fn btn-fn-outline">← Ver todas as notícias</a>
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

@media (max-width: 768px) {
    .feature-card > div {
        grid-template-columns: 1fr !important;
    }
}
</style>
