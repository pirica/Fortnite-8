<?php

declare(strict_types=1);

$newsClasses = trim('item-card news-card ' . ($newsClasses ?? ''));
$newsTitle = $newsTitle ?? '';
$newsBody = $newsBody ?? '';
$newsImageUrl = $newsImageUrl ?? '';
$newsBadgeLeft = $newsBadgeLeft ?? '';
$newsBadgeRight = $newsBadgeRight ?? '';
$newsDelay = $newsDelay ?? '0s';
?>
<div class="<?= htmlspecialchars($newsClasses) ?>" style="--news-delay: <?= htmlspecialchars((string) $newsDelay) ?>;">
    <?php if (!empty($newsBadgeRight)): ?>
    <span class="news-card__badge news-card__badge--right"><?= $newsBadgeRight ?></span>
    <?php endif; ?>

    <?php if (!empty($newsBadgeLeft)): ?>
    <span class="news-card__badge news-card__badge--left"><?= $newsBadgeLeft ?></span>
    <?php endif; ?>

    <?php if (!empty($newsImageUrl)): ?>
    <img src="<?= htmlspecialchars($newsImageUrl) ?>" alt="<?= htmlspecialchars((string) $newsTitle) ?>" loading="lazy">
    <?php endif; ?>

    <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars((string) $newsTitle) ?></h5>
        <p class="card-text news-card__body">
            <?= $newsBody ?>
        </p>
    </div>
</div>