<?php

declare(strict_types=1);

$featureIcon = $featureIcon ?? '✨';
$featureTitle = $featureTitle ?? '';
$featureText = $featureText ?? '';
$featureLink = $featureLink ?? '#';
$featureLinkLabel = $featureLinkLabel ?? 'Ver mais';
?>
<div class="feature-card">
    <div class="feature-icon"><?= htmlspecialchars((string) $featureIcon) ?></div>
    <h3><?= htmlspecialchars((string) $featureTitle) ?></h3>
    <p><?= htmlspecialchars((string) $featureText) ?></p>
    <a href="<?= htmlspecialchars((string) $featureLink) ?>" class="btn-fn"><?= htmlspecialchars((string) $featureLinkLabel) ?></a>
</div>