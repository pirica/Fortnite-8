<?php

declare(strict_types=1);

$title = $title ?? '';
$subtitle = $subtitle ?? null;
?>
<div class="page-header">
    <h1 class="text-gradient"><?= htmlspecialchars((string) $title) ?></h1>
    <?php if (!empty($subtitle)): ?>
    <p class="page-subtitle"><?= $subtitle ?></p>
    <?php endif; ?>
</div>