<div class="page-container container-fn">
    <div class="page-header">
        <h1 class="text-gradient">🎮 Notícias Battle Royale</h1>
        <?php if ($lastUpdate): ?>
        <p class="page-subtitle">
            Última atualização: <?= date('d/m/Y H:i', strtotime($lastUpdate)) ?>
        </p>
        <?php endif; ?>
    </div>
    
    <?php if (empty($news)): ?>
    <div class="state-card">
        <span style="font-size: 4rem;">🎮</span>
        <h3 style="margin: 20px 0;">Nenhuma notícia disponível</h3>
        <a href="<?= $baseUrl ?>/news" class="btn-fn">Ver todas as notícias</a>
    </div>
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
        ?>
        <div class="item-card news-card" style="animation-delay: <?= $index * 0.05 ?>s;">
            <?php if ($priority >= 5): ?>
            <span style="position: absolute; top: 10px; right: 10px; background: var(--fn-orange); padding: 3px 10px; border-radius: 4px; font-size: 0.75rem;">
                🔥 HOT
            </span>
            <?php endif; ?>
            
            <?php if ($imageUrl): ?>
            <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" loading="lazy">
            <?php endif; ?>
            
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($item['title'] ?? 'Sem título') ?></h5>
                <p class="card-text" style="color: var(--text-secondary); font-size: 0.9rem;">
                    <?= htmlspecialchars($item['body'] ?? '') ?>
                </p>
            </div>
        </div>
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
