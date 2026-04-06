<?php

declare(strict_types=1);

$itemClasses = trim('item-card ' . ($itemClasses ?? ''));
$imageUrl = $imageUrl ?? '';
$altText = $altText ?? '';
$bodyHtml = $bodyHtml ?? '';
$onErrorFallback = $onErrorFallback ?? '';
?>
<div class="<?= htmlspecialchars($itemClasses) ?>">
    <?php if (!empty($topLeftBadge)): ?>
    <span class="item-badge item-badge--left"><?= $topLeftBadge ?></span>
    <?php endif; ?>

    <?php if (!empty($topRightBadge)): ?>
    <span class="item-badge item-badge--right"><?= $topRightBadge ?></span>
    <?php endif; ?>

    <img src="<?= htmlspecialchars($imageUrl) ?>"
         alt="<?= htmlspecialchars($altText) ?>"
         loading="lazy"
         <?= $onErrorFallback !== '' ? 'onerror="' . htmlspecialchars($onErrorFallback) . '"' : '' ?>>

    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($itemTitle ?? '') ?></h5>
        <?= $bodyHtml ?>
    </div>
</div>