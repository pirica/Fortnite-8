<div class="page-container container-fn page-layout-centered page-shell">
    <?php
    $icon = '⚠️';
    $title = '500';
    $message = 'Algo deu errado no servidor. Tente novamente em instantes.';
    $actions = '<a href="' . htmlspecialchars($baseUrl) . '/" class="btn-fn">← Voltar ao Início</a>';
    $variant = 'error';
    $size = 'wide';
    include __DIR__ . '/../partials/state-card.php';
    ?>
</div>
