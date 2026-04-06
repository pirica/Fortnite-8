<?php

declare(strict_types=1);

$icon = $icon ?? 'ℹ️';
$title = $title ?? '';
$message = $message ?? '';
$actions = $actions ?? '';
$variant = $variant ?? 'default';
$size = $size ?? 'default';

$classes = trim('state-card state-card--' . $variant . ' state-card--' . $size);
?>
<div class="<?= htmlspecialchars($classes) ?>">
    <div class="state-card__icon"><?= htmlspecialchars((string) $icon) ?></div>
    <h3><?= htmlspecialchars((string) $title) ?></h3>
    <p><?= $message ?></p>
    <?php if (!empty($actions)): ?>
    <div class="state-card__actions"><?= $actions ?></div>
    <?php endif; ?>
</div>