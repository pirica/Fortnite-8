<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Fortnite Hub - Sua central de informações para Loja, Notícias e Cosméticos do Fortnite">
    <meta name="theme-color" content="#1d4fff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Fortnite Hub">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link rel="icon" href="<?= $baseUrl ?>/img/favicon.png" type="image/x-icon" />
    <link rel="apple-touch-icon" href="<?= $baseUrl ?>/img/logo.png">
    <link rel="manifest" href="<?= $baseUrl ?>/manifest.json">
    <link href="https://fonts.googleapis.com/css2?family=Russo+One&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>/css/design-system.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg"></div>

    <!-- Premium Navbar -->
    <nav class="navbar navbar-expand-lg navbar-fn">
        <div class="container">
            <a class="navbar-brand" href="<?= $baseUrl ?>/">
                <img src="<?= $baseUrl ?>/img/logo.png" alt="Fortnite Hub">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'home' ? 'active' : '' ?>" href="<?= $baseUrl ?>/">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= strpos($currentPage, 'news') !== false ? 'active' : '' ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                            Notícias
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $baseUrl ?>/news">📰 Notícias Gerais</a>
                            <a class="dropdown-item" href="<?= $baseUrl ?>/news/br">🎮 Battle Royale</a>
                            <a class="dropdown-item" href="<?= $baseUrl ?>/news/stw">⚔️ Salve o Mundo</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'cosmetics' ? 'active' : '' ?>" href="<?= $baseUrl ?>/cosmetics">Cosméticos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $currentPage === 'shop' ? 'active' : '' ?>" href="<?= $baseUrl ?>/shop">Loja</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?= in_array($currentPage, ['map', 'modes', 'player']) ? 'active' : '' ?>" href="#" id="explorarDropdown" role="button" data-toggle="dropdown">
                            Explorar
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?= $baseUrl ?>/map">🗺️ Mapa</a>
                            <a class="dropdown-item" href="<?= $baseUrl ?>/modes">🎮 Modos de Jogo</a>
                            <a class="dropdown-item" href="<?= $baseUrl ?>/player">🔍 Buscar Jogador</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <?= $content ?>

    <!-- Footer -->
    <footer class="footer-fn">
        <p>Fortnite Hub © <?= date('Y') ?> - Projeto de Portfólio</p>
        <p style="font-size: 0.8rem; margin-top: 10px;">
            Este site não é afiliado à Epic Games. Todos os dados são fornecidos pela <a href="https://fortnite-api.com/" target="_blank" style="color: var(--fn-blue);">Fortnite-API.com</a>
        </p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?= $baseUrl ?>/sw.js')
                    .then(reg => console.log('Service Worker registered:', reg.scope))
                    .catch(err => console.log('Service Worker registration failed:', err));
            });
        }
    </script>
</body>
</html>
