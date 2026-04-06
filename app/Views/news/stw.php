<div class="page-container container-fn">
    <div class="page-header">
        <h1 class="text-gradient">⚔️ Notícias Salve o Mundo</h1>
        <?php if ($lastUpdate): ?>
        <p class="page-subtitle">
            Última atualização: <?= date('d/m/Y H:i', strtotime($lastUpdate)) ?>
        </p>
        <?php endif; ?>
    </div>
    
    <?php if (empty($news)): ?>
    <div class="feature-card" style="max-width: 600px; margin: 0 auto; padding: 60px; text-align: center;">
        <span style="font-size: 4rem;">⚔️</span>
        <h3 style="margin: 20px 0;">Nenhuma notícia de Salve o Mundo</h3>
        <p style="color: var(--text-secondary); margin-bottom: 30px;">
            Não há notícias disponíveis no momento. Volte mais tarde!
        </p>
        <a href="<?= $baseUrl ?>/news" class="btn-fn">Ver notícias de Battle Royale</a>
    </div>
    <?php else: ?>
    
    <div class="items-grid" style="grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));">
        <?php foreach ($news as $index => $item): 
            $imageUrl = $item['image'] ?? '';
        ?>
        <div class="item-card news-card" style="animation-delay: <?= $index * 0.05 ?>s;">
            <?php if ($imageUrl): ?>
            <img src="<?= htmlspecialchars($imageUrl) ?>" alt="<?= htmlspecialchars($item['title'] ?? '') ?>" loading="lazy">
            <?php endif; ?>
            
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($item['title'] ?? 'Sem título') ?></h5>
                <p class="card-text" style="color: var(--text-secondary); font-size: 0.9rem;">
                    <?= htmlspecialchars($item['body'] ?? '') ?>
                </p>
                
                <?php if (!empty($item['adspace'])): ?>
                <p style="color: var(--fn-yellow); font-size: 0.85rem; margin-top: 10px;">
                    📢 <?= htmlspecialchars($item['adspace']) ?>
                </p>
                <?php endif; ?>
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
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
