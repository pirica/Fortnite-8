<div class="page-container container-fn">
    <?php
    $title = '🗺️ Mapa do Fortnite';
    $subtitle = 'Visualize o mapa atual do Battle Royale';
    include __DIR__ . '/../partials/page-header.php';
    ?>
    
    <!-- Map Options -->
    <div class="toolbar map-toolbar">
        <button class="btn-fn" onclick="showMap('poi')" id="btn-poi">🏷️ Com POIs</button>
        <button class="btn-fn btn-fn-outline" onclick="showMap('blank')" id="btn-blank">🗺️ Limpo</button>
    </div>
    
    <!-- Map Display -->
    <div class="feature-card map-panel">
        <div class="map-frame">
            <img id="map-image" 
                 src="<?= htmlspecialchars($mapUrl) ?>" 
                 alt="Mapa do Fortnite"
                 class="map-image"
                 onclick="openFullscreen()"
                 onerror="this.src='https://fortnite-api.com/images/map.png'">
        </div>
        
        <div class="map-hint">
            <p class="text-muted-soft">💡 Clique no mapa para ver em tela cheia</p>
        </div>
    </div>
    
    <!-- Season Info -->
    <div class="season-grid">
        <div class="feature-card season-card">
            <span class="season-card__icon">🏝️</span>
            <h3 class="season-card__title">Capítulo 6</h3>
            <p class="text-muted-soft">Pacific Break</p>
        </div>
        <div class="feature-card season-card">
            <span class="season-card__icon">❄️</span>
            <h3 class="season-card__title">Temporada 1</h3>
            <p class="text-muted-soft">Inverno 2024/2025</p>
        </div>
        <div class="feature-card season-card">
            <span class="season-card__icon">📍</span>
            <h3 class="season-card__title">Novo Mapa</h3>
            <p class="text-muted-soft">Ilha renovada</p>
        </div>
    </div>
    
    <!-- POI List -->
    <div class="poi-section">
        <h2 class="poi-title">
            <span class="text-gradient">📍 Pontos de Interesse (POIs)</span>
        </h2>
        
        <div class="items-grid poi-grid">
            <?php foreach ($pois as $poi): ?>
            <div class="feature-card poi-card">
                <span class="poi-card__icon"><?= $poi['icon'] ?></span>
                <p class="poi-card__name"><?= htmlspecialchars($poi['name']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Fullscreen Modal -->
<div id="fullscreen-modal" class="fullscreen-modal" onclick="closeFullscreen()">
    <img id="fullscreen-image" src="" alt="Mapa em tela cheia" class="fullscreen-modal__image">
    <button class="fullscreen-modal__close" onclick="closeFullscreen()">×</button>
</div>

<script>
const mapUrlPoi = <?= json_encode((string) $mapUrl, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
const mapUrlBlank = <?= json_encode((string) $mapUrlBlank, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;

function showMap(type) {
    const mapImg = document.getElementById('map-image');
    const btnPoi = document.getElementById('btn-poi');
    const btnBlank = document.getElementById('btn-blank');
    
    if (type === 'poi') {
        mapImg.src = mapUrlPoi;
        btnPoi.classList.remove('btn-fn-outline');
        btnBlank.classList.add('btn-fn-outline');
    } else {
        mapImg.src = mapUrlBlank;
        btnBlank.classList.remove('btn-fn-outline');
        btnPoi.classList.add('btn-fn-outline');
    }
}

function openFullscreen() {
    const modal = document.getElementById('fullscreen-modal');
    const fullImg = document.getElementById('fullscreen-image');
    const mapImg = document.getElementById('map-image');
    
    fullImg.src = mapImg.src;
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';
}

function closeFullscreen() {
    document.getElementById('fullscreen-modal').classList.remove('is-open');
    document.body.style.overflow = 'auto';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeFullscreen();
});
</script>
