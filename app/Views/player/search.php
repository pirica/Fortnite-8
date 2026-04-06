<div class="page-container container-fn">
    <?php
    $title = '🔍 Buscar Jogador';
    $subtitle = 'Pesquise estatísticas de qualquer jogador do Fortnite';
    include __DIR__ . '/../partials/page-header.php';
    ?>
    
    <!-- Search Form -->
    <form class="search-box search-box--wide" action="<?= $baseUrl ?>/player" method="GET">
        <div class="search-box__row">
            <input type="text" name="player" placeholder="🎮 Digite o nome do jogador..." 
                   value="<?= htmlspecialchars($playerName) ?>" 
                   class="search-box__input" required>
            <select name="platform" class="search-box__select">
                <option value="epic" <?= $platform === 'epic' ? 'selected' : '' ?>>Epic Games</option>
                <option value="psn" <?= $platform === 'psn' ? 'selected' : '' ?>>PlayStation</option>
                <option value="xbl" <?= $platform === 'xbl' ? 'selected' : '' ?>>Xbox</option>
            </select>
            <button type="submit">Buscar</button>
        </div>
    </form>
    
    <?php if ($error): ?>
    <?php
    $icon = '😕';
    $title = 'Jogador não encontrado';
    $message = htmlspecialchars($error) . '<br><span class="search-help">Verifique se o nome está correto e se o perfil é público.</span>';
    $variant = 'error';
    $size = 'default';
    include __DIR__ . '/../partials/state-card.php';
    ?>
    
    <?php elseif ($playerData): ?>
    
    <!-- Player Info -->
    <div class="player-profile">
        <!-- Header Card -->
        <div class="feature-card player-profile__card">
            <div class="player-profile__header">
                <div class="panel-stack__avatar">
                    🎮
                </div>
                <div class="panel-stack__content">
                    <h2 class="player-profile__title"><?= htmlspecialchars($playerData['account']['name'] ?? $playerName) ?></h2>
                    <p class="player-profile__meta">
                        ID: <?= htmlspecialchars($playerData['account']['id'] ?? 'N/A') ?>
                    </p>
                </div>
                <div class="player-profile__level">
                    <p class="player-profile__level-value">🏆 Level <?= $playerData['battlePass']['level'] ?? '0' ?></p>
                    <p class="player-profile__level-label">Battle Pass</p>
                </div>
            </div>
        </div>
        
        <!-- Overall Stats -->
        <?php if (isset($playerData['stats']['all']['overall'])): 
            $overall = $playerData['stats']['all']['overall'];
        ?>
        <h3 class="player-profile__section-title">
            <span class="text-gradient">📊 Estatísticas Gerais</span>
        </h3>
        <div class="stat-grid stat-grid--overall player-profile__grid">
            <div class="feature-card stat-card">
                <p class="stat-card__label">Partidas</p>
                <p class="stat-card__value stat-card__value--blue"><?= number_format($overall['matches'] ?? 0) ?></p>
            </div>
            <div class="feature-card stat-card">
                <p class="stat-card__label">Vitórias</p>
                <p class="stat-card__value stat-card__value--green"><?= number_format($overall['wins'] ?? 0) ?></p>
            </div>
            <div class="feature-card stat-card">
                <p class="stat-card__label">Eliminações</p>
                <p class="stat-card__value stat-card__value--orange"><?= number_format($overall['kills'] ?? 0) ?></p>
            </div>
            <div class="feature-card stat-card">
                <p class="stat-card__label">Mortes</p>
                <p class="stat-card__value stat-card__value--pink"><?= number_format($overall['deaths'] ?? 0) ?></p>
            </div>
            <div class="feature-card stat-card">
                <p class="stat-card__label">K/D Ratio</p>
                <p class="stat-card__value stat-card__value--purple"><?= number_format($overall['kd'] ?? 0, 2) ?></p>
            </div>
            <div class="feature-card stat-card">
                <p class="stat-card__label">Taxa de Vitória</p>
                <p class="stat-card__value stat-card__value--yellow"><?= number_format($overall['winRate'] ?? 0, 1) ?>%</p>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Stats by Mode -->
        <?php 
        $modes = ['solo' => 'Solo', 'duo' => 'Duos', 'squad' => 'Squads'];
        $modeIcons = ['solo' => '🎯', 'duo' => '👥', 'squad' => '👨‍👩‍👧‍👦'];
        $modeColors = ['solo' => 'var(--fn-blue)', 'duo' => 'var(--fn-green)', 'squad' => 'var(--fn-purple)'];
        ?>
        
        <h3 class="player-profile__section-title">
            <span class="text-gradient">🎮 Estatísticas por Modo</span>
        </h3>
        
        <div class="stat-grid stat-grid--mode">
            <?php foreach ($modes as $key => $label): 
                $modeStats = $playerData['stats']['all'][$key] ?? null;
                if (!$modeStats) continue;
            ?>
            <div class="feature-card stat-card stat-card--mode stat-card--mode-<?= $key ?>">
                <div class="mode-header">
                    <span class="mode-header__icon"><?= $modeIcons[$key] ?></span>
                    <h4 class="mode-header__title mode-header__title--<?= $key === 'solo' ? 'blue' : ($key === 'duo' ? 'green' : 'purple') ?>"><?= $label ?></h4>
                </div>
                
                <div class="mode-metrics">
                    <div>
                        <p class="mode-metrics__label">Partidas</p>
                        <p class="mode-metrics__value"><?= number_format($modeStats['matches'] ?? 0) ?></p>
                    </div>
                    <div>
                        <p class="mode-metrics__label">Vitórias</p>
                        <p class="mode-metrics__value stat-card__value--green"><?= number_format($modeStats['wins'] ?? 0) ?></p>
                    </div>
                    <div>
                        <p class="mode-metrics__label">K/D</p>
                        <p class="mode-metrics__value"><?= number_format($modeStats['kd'] ?? 0, 2) ?></p>
                    </div>
                    <div>
                        <p class="mode-metrics__label">Taxa Vitória</p>
                        <p class="mode-metrics__value"><?= number_format($modeStats['winRate'] ?? 0, 1) ?>%</p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <?php else: ?>
    <!-- Empty State -->
    <div class="empty-hero">
        <div class="empty-hero__icon">🎮</div>
        <h3 class="empty-hero__title">Pesquise um jogador</h3>
        <p class="empty-hero__text">
            Digite o nome de usuário Epic Games, PlayStation ou Xbox para ver as estatísticas do jogador.
        </p>
        
        <!-- Popular Players -->
        <div class="player-profile__popular">
            <p class="player-profile__popular-label">💡 Jogadores populares para testar:</p>
            <div class="player-profile__popular-links">
                <a href="<?= $baseUrl ?>/player?player=Ninja" class="btn-fn btn-fn-outline btn-fn--compact">Ninja</a>
                <a href="<?= $baseUrl ?>/player?player=Tfue" class="btn-fn btn-fn-outline btn-fn--compact">Tfue</a>
                <a href="<?= $baseUrl ?>/player?player=Bugha" class="btn-fn btn-fn-outline btn-fn--compact">Bugha</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
