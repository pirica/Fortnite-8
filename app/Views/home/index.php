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
        <div class="feature-card">
            <div class="feature-icon">🛒</div>
            <h3>Loja Diária</h3>
            <p>Confira todos os itens disponíveis na loja de hoje em tempo real.</p>
            <a href="<?= $baseUrl ?>/shop" class="btn-fn">Ver Loja</a>
        </div>
        
        <!-- News Card -->
        <div class="feature-card">
            <div class="feature-icon">📰</div>
            <h3>Últimas Notícias</h3>
            <p>Fique por dentro das atualizações, eventos e patch notes.</p>
            <a href="<?= $baseUrl ?>/news" class="btn-fn">Ver Notícias</a>
        </div>
        
        <!-- Cosmetics Card -->
        <div class="feature-card">
            <div class="feature-icon">✨</div>
            <h3>Cosméticos</h3>
            <p>Explore todos os cosméticos disponíveis no jogo.</p>
            <a href="<?= $baseUrl ?>/cosmetics" class="btn-fn">Explorar</a>
        </div>
        
        <!-- Map Card -->
        <div class="feature-card">
            <div class="feature-icon">🗺️</div>
            <h3>Mapa Atual</h3>
            <p>Veja o mapa atual do Battle Royale com todos os POIs.</p>
            <a href="<?= $baseUrl ?>/map" class="btn-fn">Ver Mapa</a>
        </div>
        
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
            <div class="item-card rarity-legendary">
                <img src="<?= htmlspecialchars($item['image']) ?>" 
                     alt="<?= htmlspecialchars($item['name']) ?>" 
                     onerror="this.src='<?= $baseUrl ?>/img/logo.png'">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                    <p class="card-text">💰 <?= number_format($item['price'], 0, ',', '.') ?> V-Bucks</p>
                </div>
            </div>
            <?php endforeach; ?>
        <?php elseif (!empty($apiError)): ?>
            <div class="state-card" style="grid-column: 1/-1;">
                <h3>Não foi possível carregar os destaques</h3>
                <p><?= htmlspecialchars($apiError) ?></p>
            </div>
        <?php else: ?>
            <div class="feature-card loading-shimmer" style="height: 220px; grid-column: 1/-1;"></div>
        <?php endif; ?>
    </div>
    
    <div style="text-align: center; margin-top: 40px;">
        <a href="<?= $baseUrl ?>/shop" class="btn-fn btn-fn-outline">Ver Loja Completa →</a>
    </div>
</section>
