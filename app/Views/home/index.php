<!-- Hero Section -->
<section class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Fortnite Hub</h1>
        <p class="hero-subtitle">
            Sua central de informações para <span>Loja</span>, <span>Notícias</span> e <span>Cosméticos</span>
        </p>
        
        <!-- Search Box -->
        <form class="search-box" action="<?= $baseUrl ?>/cosmetics" method="GET">
            <input type="text" name="query" placeholder="🔍 Buscar cosméticos, skins, emotes...">
            <button type="submit">Buscar</button>
        </form>
        
        <!-- Server Status -->
        <div class="status-indicator">
            <span class="status-dot"></span>
            <span>Servidores Online</span>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="container-fn" style="margin-top: -60px; position: relative; z-index: 10;">
    <div class="features-grid">
        
        <!-- Shop Card -->
        <?php
        $featureIcon = '🛒';
        $featureTitle = 'Loja Diária';
        $featureText = 'Confira todos os itens disponíveis na loja de hoje em tempo real.';
        $featureLink = $baseUrl . '/shop';
        $featureLinkLabel = 'Ver Loja';
        include __DIR__ . '/../partials/feature-card.php';
        ?>
        
        <!-- News Card -->
        <?php
        $featureIcon = '📰';
        $featureTitle = 'Últimas Notícias';
        $featureText = 'Fique por dentro das atualizações, eventos e patch notes.';
        $featureLink = $baseUrl . '/news';
        $featureLinkLabel = 'Ver Notícias';
        include __DIR__ . '/../partials/feature-card.php';
        ?>
        
        <!-- Cosmetics Card -->
        <?php
        $featureIcon = '✨';
        $featureTitle = 'Cosméticos';
        $featureText = 'Explore todos os cosméticos disponíveis no jogo.';
        $featureLink = $baseUrl . '/cosmetics';
        $featureLinkLabel = 'Explorar';
        include __DIR__ . '/../partials/feature-card.php';
        ?>
        
        <!-- Map Card -->
        <?php
        $featureIcon = '🗺️';
        $featureTitle = 'Mapa Atual';
        $featureText = 'Veja o mapa atual do Battle Royale com todos os POIs.';
        $featureLink = $baseUrl . '/map';
        $featureLinkLabel = 'Ver Mapa';
        include __DIR__ . '/../partials/feature-card.php';
        ?>
        
    </div>
</section>

<!-- Live Shop Preview -->
<section class="container-fn" style="margin-top: 80px;">
    <h2 style="text-align: center; margin-bottom: 40px;">
        <span class="text-gradient">🔥 Destaques da Loja</span>
    </h2>
    
    <div class="items-grid" style="max-width: 1000px; margin: 0 auto;">
        <?php if (!empty($featuredItems)): ?>
            <?php foreach ($featuredItems as $item): ?>
            <?php
            $itemClasses = 'rarity-legendary item-card--feature';
            $imageUrl = (string) $item['image'];
            $altText = (string) $item['name'];
            $itemTitle = (string) $item['name'];
            $bodyHtml = '<p class="card-text">💰 ' . number_format((float) $item['price'], 0, ',', '.') . ' V-Bucks</p>';
            $onErrorFallback = "this.src='" . $baseUrl . "/img/logo.png'";
            include __DIR__ . '/../partials/item-card.php';
            ?>
            <?php endforeach; ?>
        <?php elseif (!empty($apiError)): ?>
            <?php
            $icon = '⚠️';
            $title = 'Não foi possível carregar os destaques';
            $message = htmlspecialchars($apiError);
            $variant = 'default';
            $size = 'wide';
            include __DIR__ . '/../partials/state-card.php';
            ?>
        <?php else: ?>
            <div class="feature-card loading-shimmer" style="height: 220px; grid-column: 1/-1;"></div>
        <?php endif; ?>
    </div>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?= $baseUrl ?>/shop" class="btn-fn btn-fn-outline">Ver Loja Completa →</a>
    </div>
</section>
