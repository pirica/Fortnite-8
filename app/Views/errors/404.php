<div class="page-container container-fn" style="text-align: center; padding-top: 150px;">
    <?php
    $icon = '🔍';
    $title = '404';
    $message = 'A página que você está procurando não existe ou foi movida. Verifique a URL ou volte para a página inicial.';
    $actions = '<a href="' . htmlspecialchars($baseUrl) . '/" class="btn-fn">← Voltar ao Início</a>';
    $variant = 'default';
    $size = 'wide';
    include __DIR__ . '/../partials/state-card.php';
    ?>
</div>
