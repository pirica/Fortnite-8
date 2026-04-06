<div class="page-container container-fn">
    <div class="page-header">
        <h1 class="text-gradient">✨ Cosméticos</h1>
        <p class="page-subtitle">Explore todos os cosméticos do Fortnite</p>
    </div>
    
    <!-- Search Bar -->
    <form id="search-form" class="search-box search-box--narrow" action="<?= $baseUrl ?>/cosmetics" method="GET">
        <input type="text" name="query" id="search-input" placeholder="🔍 Buscar cosméticos..." 
               value="<?= htmlspecialchars($searchQuery) ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <div id="results-info" class="results-info" hidden>
        <p class="results-info__text">
            Mostrando resultados para: <strong id="search-term"></strong>
        </p>
    </div>
    
    <div class="items-grid" id="cosmetics-grid">
        <!-- Items loaded via JavaScript -->
    </div>
    
    <!-- Loading indicator -->
    <div id="loading" class="status-panel" hidden>
        <div class="spinner"></div>
        <p class="status-panel__text status-panel__text--spaced">Carregando cosméticos...</p>
    </div>
    
    <!-- End message -->
    <div id="end-message" class="status-panel" hidden>
        <p class="status-panel__text">✅ Todos os cosméticos foram carregados!</p>
    </div>
</div>

<script>
const popularSkins = <?= json_encode($popularSkins, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
const basePath = '<?= $baseUrl ?>';
let currentPage = 1;
let isLoading = false;
let hasMore = true;
let currentQuery = <?= json_encode((string) $searchQuery, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
let allItems = [];

const grid = document.getElementById('cosmetics-grid');
const loading = document.getElementById('loading');
const endMessage = document.getElementById('end-message');
const resultsInfo = document.getElementById('results-info');
const searchTerm = document.getElementById('search-term');

async function loadCosmetics() {
    if (isLoading || !hasMore) return;
    
    isLoading = true;
    loading.hidden = false;
    
    try {
        const response = await fetch(`${basePath}/cosmetics/api?query=${encodeURIComponent(currentQuery)}&page=${currentPage}`);
        const data = await response.json();
        
        if (data.items && data.items.length > 0) {
            data.items.forEach((item, index) => {
                const card = createCard(item, index);
                grid.appendChild(card);
            });
            
            currentPage++;
            hasMore = data.hasMore;
        } else {
            hasMore = false;
        }
        
        if (!hasMore) {
            endMessage.hidden = false;
        }
    } catch (error) {
        const errorCard = document.createElement('div');
        errorCard.className = 'feature-card state-inline-error';
        errorCard.innerHTML = `
            <h3>Falha ao carregar cosméticos</h3>
            <p class="status-panel__text">A API está instável no momento. Tente novamente em alguns segundos.</p>
        `;
        grid.appendChild(errorCard);
    }
    
    loading.hidden = true;
    isLoading = false;
}

function createCard(item, index) {
    const rarity = item.rarity?.value?.toLowerCase() || 'common';
    const imageUrl = item.images?.featured || item.images?.icon || basePath + '/img/logo.png';
    
    const card = document.createElement('a');
    card.href = `${basePath}/cosmetics/${item.id}`;
    card.className = `item-card rarity-${rarity} cosmetic-item`;
    card.style.setProperty('--card-delay', `${index * 0.05}s`);
    card.innerHTML = `
        <img src="${imageUrl}" alt="${item.name}" loading="lazy" onerror="this.src='${basePath}/img/logo.png'">
        <div class="card-body">
            <h5 class="card-title">${item.name}</h5>
            <p class="card-text cosmetic-item__meta">
                ${item.type?.displayValue || ''}
            </p>
        </div>
    `;
    
    return card;
}

// Infinite scroll
window.addEventListener('scroll', () => {
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
        loadCosmetics();
    }
});

// Show results info if searching
if (currentQuery) {
    resultsInfo.hidden = false;
    searchTerm.textContent = currentQuery;
}

// Initial load
loadCosmetics();
</script>
