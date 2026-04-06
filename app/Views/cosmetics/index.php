<div class="page-container container-fn">
    <div class="page-header">
        <h1 class="text-gradient">✨ Cosméticos</h1>
        <p class="page-subtitle">Explore todos os cosméticos do Fortnite</p>
    </div>
    
    <!-- Search Bar -->
    <form id="search-form" class="search-box" action="<?= $baseUrl ?>/cosmetics" method="GET" style="max-width: 500px; margin: 0 auto 40px;">
        <input type="text" name="query" id="search-input" placeholder="🔍 Buscar cosméticos..." 
               value="<?= htmlspecialchars($searchQuery) ?>">
        <button type="submit">Buscar</button>
    </form>
    
    <div id="results-info" style="text-align: center; margin-bottom: 20px; display: none;">
        <p style="color: var(--text-secondary);">
            Mostrando resultados para: <strong id="search-term"></strong>
        </p>
    </div>
    
    <div class="items-grid" id="cosmetics-grid">
        <!-- Items loaded via JavaScript -->
    </div>
    
    <!-- Loading indicator -->
    <div id="loading" style="text-align: center; padding: 40px; display: none;">
        <div class="spinner"></div>
        <p style="color: var(--text-secondary); margin-top: 15px;">Carregando cosméticos...</p>
    </div>
    
    <!-- End message -->
    <div id="end-message" style="text-align: center; padding: 40px; display: none;">
        <p style="color: var(--text-secondary);">✅ Todos os cosméticos foram carregados!</p>
    </div>
</div>

<style>
.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid rgba(157, 78, 221, 0.2);
    border-top-color: var(--fn-purple);
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.cosmetic-item {
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
}
</style>

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
    loading.style.display = 'block';
    
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
            endMessage.style.display = 'block';
        }
    } catch (error) {
        const errorCard = document.createElement('div');
        errorCard.className = 'feature-card';
        errorCard.style.gridColumn = '1 / -1';
        errorCard.style.textAlign = 'center';
        errorCard.style.padding = '32px';
        errorCard.innerHTML = `
            <h3>Falha ao carregar cosméticos</h3>
            <p style="color: var(--text-secondary)">A API está instável no momento. Tente novamente em alguns segundos.</p>
        `;
        grid.appendChild(errorCard);
    }
    
    loading.style.display = 'none';
    isLoading = false;
}

function createCard(item, index) {
    const rarity = item.rarity?.value?.toLowerCase() || 'common';
    const imageUrl = item.images?.featured || item.images?.icon || basePath + '/img/logo.png';
    
    const card = document.createElement('a');
    card.href = `${basePath}/cosmetics/${item.id}`;
    card.className = `item-card rarity-${rarity} cosmetic-item`;
    card.style.animationDelay = `${index * 0.05}s`;
    card.innerHTML = `
        <img src="${imageUrl}" alt="${item.name}" loading="lazy" onerror="this.src='${basePath}/img/logo.png'">
        <div class="card-body">
            <h5 class="card-title">${item.name}</h5>
            <p class="card-text" style="color: var(--text-secondary); font-size: 0.85rem;">
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
    resultsInfo.style.display = 'block';
    searchTerm.textContent = currentQuery;
}

// Initial load
loadCosmetics();
</script>
