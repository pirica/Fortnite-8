<div class="page-container container-fn">
    <?php
    $title = '🎮 Modos de Jogo';
    $subtitle = 'Todos os modos disponíveis no Fortnite';
    include __DIR__ . '/../partials/page-header.php';
    ?>
    
    <!-- Category Filter -->
    <div class="toolbar">
        <button class="btn-fn filter-btn is-active" onclick="filterPlaylists('all', this)">📋 Todos</button>
        <button class="btn-fn btn-fn-outline filter-btn" onclick="filterPlaylists('br', this)">🎯 Battle Royale</button>
        <button class="btn-fn btn-fn-outline filter-btn" onclick="filterPlaylists('zerobuild', this)">🔨 Zero Build</button>
        <button class="btn-fn btn-fn-outline filter-btn" onclick="filterPlaylists('festival', this)">🎵 Festival</button>
        <button class="btn-fn btn-fn-outline filter-btn" onclick="filterPlaylists('racing', this)">🏎️ Rocket Racing</button>
    </div>
    
    <div class="items-grid items-grid--playlists" id="playlists-grid">
        <?php foreach ($playlists as $index => $playlist): ?>
        <div class="playlist-card" data-type="<?= $playlist['type'] ?>" style="--playlist-delay: <?= $index * 0.05 ?>s; --playlist-color: <?= htmlspecialchars((string) $playlist['color']) ?>;">
            <div class="item-card playlist-card__item">
                <div class="card-body playlist-card__body">
                    <div class="playlist-card__header">
                        <span class="playlist-card__icon"><?= $playlist['icon'] ?></span>
                        <div>
                            <h4 class="playlist-card__title"><?= htmlspecialchars($playlist['name']) ?></h4>
                            <span class="playlist-card__type">
                                <?= $types[$playlist['type']] ?? 'Outro' ?>
                            </span>
                        </div>
                    </div>
                    <p class="playlist-card__desc">
                        <?= htmlspecialchars($playlist['desc']) ?>
                    </p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Stats -->
    <div class="modes-summary">
        <div class="feature-card modes-summary__card">
            <p class="modes-summary__label">Total de modos principais</p>
            <p class="modes-summary__value"><?= count($playlists) ?></p>
        </div>
    </div>
</div>

<script>
function filterPlaylists(type, trigger) {
    const cards = document.querySelectorAll('.playlist-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    buttons.forEach(btn => {
        btn.classList.remove('is-active');
        btn.classList.add('btn-fn-outline');
    });
    if (trigger) {
        trigger.classList.add('is-active');
        trigger.classList.remove('btn-fn-outline');
    }
    
    cards.forEach(card => {
        card.style.display = (type === 'all' || card.dataset.type === type) ? 'block' : 'none';
    });
}
</script>
