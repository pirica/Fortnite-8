<div class="page-container container-fn">
    <?php
    $title = '⚔️ Notícias Salve o Mundo';
    $subtitle = $lastUpdate ? 'Última atualização: ' . date('d/m/Y H:i', strtotime($lastUpdate)) : null;
    include __DIR__ . '/../partials/page-header.php';
    ?>
    
    <?php if (empty($news)): ?>
    <?php
    $icon = '⚔️';
    $title = 'Nenhuma notícia de Salve o Mundo';
    $message = 'Não há notícias disponíveis no momento. Volte mais tarde!';
    $actions = '<a href="' . htmlspecialchars($baseUrl) . '/news" class="btn-fn">Ver notícias de Battle Royale</a>';
    $variant = 'default';
    $size = 'default';
    include __DIR__ . '/../partials/state-card.php';
    ?>
    <?php else: ?>
    
    <div class="items-grid section-wide-grid">
        <?php foreach ($news as $index => $item): 
            $imageUrl = $item['image'] ?? '';
            $newsClasses = '';
            $newsTitle = $item['title'] ?? 'Sem título';
            $newsBody = htmlspecialchars((string) ($item['body'] ?? ''));
            if (!empty($item['adspace'])) {
                $newsBody .= '<p class="news-card__body--notice">📢 ' . htmlspecialchars((string) $item['adspace']) . '</p>';
            }
            $newsImageUrl = $imageUrl;
            $newsBadgeLeft = '';
            $newsBadgeRight = '';
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
