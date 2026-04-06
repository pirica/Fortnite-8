<?php 

// Safe string helper function
function safeStr($value, $default = ''): string {
    if (is_string($value)) {
        return $value;
    }
    return $default;
}

// Get image URL safely
$featuredImg = $item['images']['featured'] ?? null;
$iconImg = $item['images']['icon'] ?? null;

$imageUrl = $baseUrl . '/img/logo.png';
if (is_string($featuredImg) && !empty($featuredImg)) {
    $imageUrl = $featuredImg;
} elseif (is_string($iconImg) && !empty($iconImg)) {
    $imageUrl = $iconImg;
}

$rarity = strtolower(safeStr($item['rarity']['value'] ?? null, 'common'));
$itemName = safeStr($item['name'] ?? null, 'Cosmético');
?>
<div class="page-container container-fn">
    <a href="<?= $baseUrl ?>/cosmetics" class="btn-fn btn-fn-outline btn-fn--spaced">← Voltar</a>
    
    <div class="content-grid content-grid--cosmetic content-wide">
        <!-- Image Section -->
        <div>
            <div class="feature-card content-card page-layout-centered">
                <img src="<?= htmlspecialchars($imageUrl) ?>" 
                     alt="<?= htmlspecialchars($itemName) ?>" 
                     class="detail-image detail-image--<?= htmlspecialchars($rarity) ?>"
                     onerror="this.src='<?= $baseUrl ?>/img/logo.png'">
                
                <!-- LEGO/Bean versions -->
                <?php 
                $legoImg = $item['images']['lego'] ?? null;
                $beanImg = $item['images']['bean'] ?? null;
                ?>
                <div class="variant-list variant-list--center">
                    <?php if (!empty($legoImg) && is_string($legoImg)): ?>
                    <div class="variant-item variant-item--small">
                        <img src="<?= htmlspecialchars($legoImg) ?>" 
                             alt="LEGO Version" class="variant-item__image variant-item__image--full">
                        <p class="variant-item__label variant-item__label--muted">🧱 LEGO</p>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($beanImg) && is_string($beanImg)): ?>
                    <div class="variant-item variant-item--small">
                        <img src="<?= htmlspecialchars($beanImg) ?>" 
                             alt="Fall Guys Version" class="variant-item__image variant-item__image--full">
                        <p class="variant-item__label variant-item__label--muted">🫘 Fall Guys</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Info Section -->
        <div>
            <!-- Title and Series Badge -->
            <div class="panel-stack panel-stack--header detail-header-row">
                <h1 class="detail-title"><?= htmlspecialchars($itemName) ?></h1>
                
                <?php 
                $series = $item['series'] ?? null;
                if (!empty($series) && is_array($series)): 
                    $seriesValue = safeStr($series['value'] ?? null, '');
                    $color1 = safeStr($series['colors']['color1'] ?? null, 'var(--fn-purple)');
                    $color2 = safeStr($series['colors']['color2'] ?? null, 'var(--fn-blue)');
                ?>
                <span class="detail-badge detail-badge--series" style="--series-start: <?= htmlspecialchars($color1) ?>; --series-end: <?= htmlspecialchars($color2) ?>;">
                    ⭐ <?= htmlspecialchars($seriesValue) ?>
                </span>
                <?php endif; ?>
            </div>
            
            <!-- Rarity Badge -->
            <span class="detail-badge detail-badge--rarity detail-rarity--<?= htmlspecialchars($rarity) ?>">
                <?= htmlspecialchars(ucfirst($rarity)) ?>
            </span>
            
            <!-- Description -->
            <?php $description = safeStr($item['description'] ?? null, ''); ?>
            <?php if (!empty($description)): ?>
            <p class="detail-text">
                "<?= htmlspecialchars($description) ?>"
            </p>
            <?php endif; ?>
            
            <!-- Info Cards -->
            <div class="detail-info-grid">
                <?php 
                $type = $item['type'] ?? null;
                if (!empty($type) && is_array($type)): 
                ?>
                <div class="feature-card detail-info-card">
                    <p class="detail-info-card__label">Tipo</p>
                    <p class="detail-info-card__value"><?= htmlspecialchars(safeStr($type['displayValue'] ?? null, 'N/A')) ?></p>
                </div>
                <?php endif; ?>
                
                <?php 
                $set = $item['set'] ?? null;
                if (!empty($set) && is_array($set)): 
                ?>
                <div class="feature-card detail-info-card">
                    <p class="detail-info-card__label">Conjunto</p>
                    <p class="detail-info-card__value"><?= htmlspecialchars(safeStr($set['value'] ?? null, 'N/A')) ?></p>
                </div>
                <?php endif; ?>
                
                <?php 
                $intro = $item['introduction'] ?? null;
                if (!empty($intro) && is_array($intro)): 
                    $introText = safeStr($intro['text'] ?? null, '');
                    if (empty($introText)) {
                        $chapter = $intro['chapter'] ?? '?';
                        $season = $intro['season'] ?? '?';
                        $introText = "Capítulo $chapter - Temporada $season";
                    }
                ?>
                <div class="feature-card detail-info-card">
                    <p class="detail-info-card__label">Introduzido</p>
                    <p class="detail-info-card__value"><?= htmlspecialchars($introText) ?></p>
                </div>
                <?php endif; ?>
                
                <?php 
                $added = safeStr($item['added'] ?? null, '');
                if (!empty($added)): 
                ?>
                <div class="feature-card detail-info-card">
                    <p class="detail-info-card__label">Adicionado em</p>
                    <p class="detail-info-card__value"><?= date('d/m/Y', strtotime($added)) ?></p>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Showcase Video -->
            <?php 
            $video = safeStr($item['showcaseVideo'] ?? null, '');
            if (!empty($video)): 
            ?>
            <div class="detail-video">
                <h3 class="detail-video__title">🎬 Vídeo de Demonstração</h3>
                <div class="detail-video__frame">
                    <iframe 
                        src="https://www.youtube.com/embed/<?= htmlspecialchars($video) ?>" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Variants Section -->
    <?php 
    $variants = $item['variants'] ?? [];
    if (!empty($variants) && is_array($variants)): 
    ?>
    <div class="detail-section">
        <h2 class="section-title-center detail-section__title">
            <span class="text-gradient">🎨 Variantes</span>
        </h2>
        
        <?php foreach ($variants as $variant): 
            if (!is_array($variant)) continue;
        ?>
        <div class="feature-card variant-card">
            <h4 class="variant-card__title"><?= htmlspecialchars(safeStr($variant['type'] ?? $variant['channel'] ?? null, 'Variante')) ?></h4>
            <div class="variant-list">
                <?php 
                $options = $variant['options'] ?? [];
                foreach ($options as $option): 
                    if (!is_array($option)) continue;
                    $optionImage = safeStr($option['image'] ?? null, '');
                    $optionName = safeStr($option['name'] ?? null, '');
                ?>
                <div class="variant-item">
                    <?php if (!empty($optionImage)): ?>
                    <img src="<?= htmlspecialchars($optionImage) ?>" 
                         alt="<?= htmlspecialchars($optionName) ?>"
                         class="variant-item__image">
                    <?php endif; ?>
                    <p class="variant-item__label"><?= htmlspecialchars($optionName) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
