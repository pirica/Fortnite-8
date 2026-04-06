<div class="page-container container-fn">
    <?php
    $title = '🛒 Loja de Hoje';
    $subtitle = $shopDate ? 'Atualizada em: ' . date('d/m/Y H:i', strtotime($shopDate)) : null;
    include __DIR__ . '/../partials/page-header.php';
    ?>
    
    <!-- Search Bar -->
    <form class="search-box search-box--narrow" action="<?= $baseUrl ?>/shop" method="GET">
        <input type="text" name="query" placeholder="🔍 Buscar na loja..." 
               value="<?= htmlspecialchars($searchQuery) ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <?php if (!empty($apiError)): ?>
    <?php
    $icon = '⚠️';
    $title = 'Loja temporariamente indisponível';
    $message = htmlspecialchars($apiError);
    $variant = 'error';
    $size = 'default';
    include __DIR__ . '/../partials/state-card.php';
    ?>
    <?php elseif (empty($sections)): ?>
    <?php
    $icon = '🛍️';
    $title = 'Nenhum item encontrado';
    $message = 'Tente buscar por outro termo.';
    $variant = 'default';
    $size = 'default';
    include __DIR__ . '/../partials/state-card.php';
    ?>
    <?php else: ?>
    
    <?php foreach ($sections as $sectionName => $items): ?>
    <section class="section-block">
        <h2 class="section-head">
            <span class="text-gradient"><?= htmlspecialchars($sectionName) ?></span>
            <span class="chip">
                <?= count($items) ?> itens
            </span>
        </h2>
        
        <div class="items-grid">
            <?php foreach ($items as $item): ?>
            <?php
            $itemClasses = 'rarity-' . (string) $item['rarity'];
            $imageUrl = (string) $item['image'];
            $altText = (string) $item['name'];
            $itemTitle = (string) $item['name'];
            $topLeftBadge = !empty($item['series']) ? '⭐ ' . htmlspecialchars((string) $item['series']) : '';
            $topRightBadge = !empty($item['banner']) ? htmlspecialchars((string) $item['banner']) : '';
            $bodyHtml = '';

            if (!empty($item['type'])) {
                $bodyHtml .= '<p class="item-meta-type">' . htmlspecialchars((string) $item['type']) . '</p>';
            }

            $bodyHtml .= '<p class="card-text">';
            if ((float) $item['regularPrice'] > (float) $item['price']) {
                $bodyHtml .= '<span class="price-old">' . number_format((float) $item['regularPrice'], 0, ',', '.') . '</span>';
            }
            $bodyHtml .= '💰 ' . number_format((float) $item['price'], 0, ',', '.') . ' V-Bucks</p>';

            if (!empty($item['giftable'])) {
                $bodyHtml .= '<span class="giftable-label">🎁 Presenteável</span>';
            }

            $onErrorFallback = "this.src='" . $baseUrl . "/img/logo.png'";
            include __DIR__ . '/../partials/item-card.php';
            ?>
            <?php endforeach; ?>
        </div>
    </section>
    <?php endforeach; ?>
    
    <?php endif; ?>
</div>

