// Função para alternar dropdowns (deve estar no escopo global)
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}

// Expor a função no escopo global para uso em onclick
window.toggleDropdown = toggleDropdown;

// Mapeamento de valores para URLs amigáveis
const friendlyMappings = {
    gender: {
        'masculine': 'masculino',
        'feminine': 'feminino',
        'unisex': 'unisex',
        'kids': 'infantil',
    },
    sort: {
        'most_sold': 'mais-vendidos',
        'newest': 'novidades',
        'promotions': 'promocoes',
        'price_asc': 'preco-menor',
        'price_desc': 'preco-maior',
    },
    product_type: {
        'uniforme': 'uniforme',
        'casual': 'casual',
        'acessorios': 'acessorios',
    },
    category: {
        'Retro': 'retro',
        'torcedor': 'torcedor',
        'jogador': 'jogador',
        'treino': 'treino',
    },
    national_international: {
        'Sim': 'nacional',
        'Não': 'internacional',
    },
};

// Função para converter filtros em URL amigável
function filtersToFriendlyUrl(filters, basePath = '/camisas') {
    const segments = [];
    
    // Time (primeiro segmento se existir)
    if (filters.team && filters.team !== '') {
        segments.push(filters.team);
    }
    
    // Gênero (múltiplos valores unidos por '-')
    if (filters.gender && filters.gender !== '') {
        const genders = filters.gender.split(',');
        const friendlyGenders = genders
            .map(g => friendlyMappings.gender[g.trim()])
            .filter(g => g);
        if (friendlyGenders.length > 0) {
            segments.push(friendlyGenders.join('-'));
        }
    }
    
    // Temporada (formato 23-24)
    if (filters.season && filters.season !== '') {
        segments.push(filters.season.replace('/', '-'));
    }
    
    // Categoria (múltiplos valores)
    if (filters.category && filters.category !== '') {
        const categories = filters.category.split(',');
        const friendlyCategories = categories
            .map(c => {
                const trimmed = c.trim();
                return friendlyMappings.category[trimmed] || trimmed.toLowerCase();
            })
            .filter(c => c);
        if (friendlyCategories.length > 0) {
            segments.push([...new Set(friendlyCategories)].join('-'));
        }
    }
    
    // Tipo de produto
    if (filters.product_type && filters.product_type !== '') {
        segments.push(friendlyMappings.product_type[filters.product_type] || filters.product_type.toLowerCase());
    }
    
    // Nacional/Internacional (apenas se for um único valor)
    if (filters.national_international && filters.national_international !== '') {
        const nationalInt = filters.national_international.split(',');
        if (nationalInt.length === 1) {
            const value = nationalInt[0].trim();
            segments.push(friendlyMappings.national_international[value] || '');
        }
    }
    
    // Tamanho (múltiplos valores)
    if (filters.size && filters.size !== '') {
        const sizes = filters.size.split(',');
        segments.push('tamanho-' + sizes.map(s => s.toLowerCase()).join('-'));
    }
    
    // Preço máximo
    if (filters.price_max && filters.price_max !== '' && filters.price_max !== '500') {
        segments.push('ate-' + parseInt(filters.price_max));
    }
    
    // Ordenação (último segmento, padrão: mais-vendidos)
    const sort = filters.sort || 'most_sold';
    if (sort !== 'most_sold') {
        segments.push(friendlyMappings.sort[sort] || 'mais-vendidos');
    }
    
    // Construir URL
    let url = basePath;
    if (segments.length > 0) {
        url += '/' + segments.join('/');
    }
    
    // Adicionar página se for diferente de 1
    if (filters.page && parseInt(filters.page) > 1) {
        url += '/pagina-' + parseInt(filters.page);
    }
    
    return url;
}

// Função para obter todos os filtros do formulário
function getFiltersFromForm() {
    const filters = {};
    
    // Filtro de preço
    const priceSlider = document.getElementById('priceSlider');
    if (priceSlider && priceSlider.value && priceSlider.value !== '500') {
        filters.price_max = priceSlider.value;
    }
    
    // Filtro de ordenação
    const sortSelect = document.getElementById('sortSelectOrdenar');
    if (sortSelect && sortSelect.dataset.sort && sortSelect.dataset.sort !== 'most_sold') {
        filters.sort = sortSelect.dataset.sort;
    }
    
    // Filtro de time
    const teamSelect = document.getElementById('sortSelectTime');
    if (teamSelect && teamSelect.dataset.team !== undefined && teamSelect.dataset.team !== '') {
        filters.team = teamSelect.dataset.team;
    }
    
    // Filtro de temporada
    const seasonSelect = document.getElementById('sortSelectTemporada');
    if (seasonSelect && seasonSelect.dataset.season !== undefined && seasonSelect.dataset.season !== '') {
        filters.season = seasonSelect.dataset.season;
    }
    
    // Filtro de tipo de produto
    const productTypeSelect = document.getElementById('sortSelectTipo');
    if (productTypeSelect && productTypeSelect.dataset.productType !== undefined && productTypeSelect.dataset.productType !== '') {
        filters.product_type = productTypeSelect.dataset.productType;
    }
    
    // Checkboxes
    const checkboxFilters = {
        'gender': document.querySelectorAll('input[type="checkbox"][value="masculine"], input[type="checkbox"][value="feminine"], input[type="checkbox"][value="unisex"], input[type="checkbox"][value="kids"]'),
        'size': document.querySelectorAll('input[type="checkbox"][value="P"], input[type="checkbox"][value="M"], input[type="checkbox"][value="G"], input[type="checkbox"][value="GG"]'),
        'category': document.querySelectorAll('input[type="checkbox"][value="Retro"], input[type="checkbox"][value="torcedor"], input[type="checkbox"][value="jogador"], input[type="checkbox"][value="treino"]'),
        'national_international': document.querySelectorAll('input[type="checkbox"][value="Sim"], input[type="checkbox"][value="Não"]')
    };
    
    Object.entries(checkboxFilters).forEach(([param, checkboxes]) => {
        const checkedValues = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        if (checkedValues.length > 0) {
            filters[param] = checkedValues.join(',');
        }
    });
    
    return filters;
}

// Função para aplicar filtros com URLs amigáveis
function applyFilters() {
    const currentUrl = new URL(window.location);
    const filters = getFiltersFromForm();
    
    // BasePath sempre será /camisas
    const basePath = '/camisas';
    
    // Gerar URL amigável
    const friendlyUrl = filtersToFriendlyUrl(filters, basePath);
    
    // Redirecionar com a URL amigável
    window.location.href = friendlyUrl;
}

// Adiciona listeners para todas as dropdowns
function setupDropdown(dropdownId, buttonId, dataAttribute) {
    const links = document.querySelectorAll(`#${dropdownId} a`);
    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const selectedText = this.textContent;
            const selectedValue = this.getAttribute(dataAttribute);
            const button = document.getElementById(buttonId);
            
            button.childNodes[0].nodeValue = selectedText + " ";
            button.dataset[dataAttribute.replace('data-', '')] = selectedValue;
            
            document.getElementById(dropdownId).style.display = "none";
            applyFilters();
        });
    });
}

// Função para extrair filtros da URL amigável (simplificada para indicadores)
function getFiltersFromUrl() {
    const currentUrl = new URL(window.location);
    const pathSegments = currentUrl.pathname.split('/').filter(s => s && s !== 'camisas');
    const filters = {};
    
    // Processar segmentos básicos (simplificado para indicadores)
    pathSegments.forEach(segment => {
        if (segment.startsWith('pagina-')) return; // Ignorar página
        if (segment.startsWith('ate-')) {
            filters.price_max = segment.replace('ate-', '');
        } else if (segment.startsWith('tamanho-')) {
            filters.size = segment.replace('tamanho-', '');
        } else if (/^\d{2}-\d{2}$/.test(segment)) {
            filters.season = segment.replace('-', '/');
        }
    });
    
    return filters;
}

// Função para atualizar indicadores visuais de filtros ativos
function updateActiveFilterIndicators() {
    let hasAnyActiveFilters = false;
    const urlFilters = getFiltersFromUrl();

    // Atualizar indicadores de checkboxes
    document.querySelectorAll('.filter-group.checkbox').forEach(group => {
        const checkboxes = group.querySelectorAll('input[type="checkbox"]');
        const hasActiveFilters = Array.from(checkboxes).some(cb => cb.checked);
        
        if (hasActiveFilters) {
            group.classList.add('has-active-filters');
            hasAnyActiveFilters = true;
        } else {
            group.classList.remove('has-active-filters');
        }
    });

    // Atualizar indicadores de dropdowns baseado na URL e no estado do formulário
    const sortSelect = document.getElementById('sortSelectOrdenar');
    if (sortSelect && sortSelect.dataset.sort && sortSelect.dataset.sort !== 'most_sold') {
        sortSelect.classList.add('active');
        hasAnyActiveFilters = true;
    } else {
        sortSelect?.classList.remove('active');
    }
    
    const teamSelect = document.getElementById('sortSelectTime');
    if (teamSelect && teamSelect.dataset.team && teamSelect.dataset.team !== '') {
        teamSelect.classList.add('active');
        hasAnyActiveFilters = true;
    } else {
        teamSelect?.classList.remove('active');
    }
    
    const seasonSelect = document.getElementById('sortSelectTemporada');
    if (seasonSelect && seasonSelect.dataset.season && seasonSelect.dataset.season !== '' && seasonSelect.dataset.season !== 'Todos') {
        seasonSelect.classList.add('active');
        hasAnyActiveFilters = true;
    } else {
        seasonSelect?.classList.remove('active');
    }
    
    const productTypeSelect = document.getElementById('sortSelectTipo');
    if (productTypeSelect && productTypeSelect.dataset.productType && productTypeSelect.dataset.productType !== '' && productTypeSelect.dataset.productType !== 'Todos') {
        productTypeSelect.classList.add('active');
        hasAnyActiveFilters = true;
    } else {
        productTypeSelect?.classList.remove('active');
    }

    // Atualizar indicador do slider de preço
    const priceSlider = document.getElementById('priceSlider');
    if (priceSlider && ((urlFilters.price_max && urlFilters.price_max !== '250') || (priceSlider.value && priceSlider.value !== '250' && priceSlider.value !== '500'))) {
        priceSlider.parentElement.classList.add('has-active-filters');
        hasAnyActiveFilters = true;
    } else {
        priceSlider?.parentElement.classList.remove('has-active-filters');
    }

    // Mostrar/ocultar botão "Limpar Filtros"
    const clearFiltersBtn = document.getElementById('clearFilters');
    if (clearFiltersBtn) {
        if (hasAnyActiveFilters) {
            clearFiltersBtn.style.display = 'inline-block';
        } else {
            clearFiltersBtn.style.display = 'none';
        }
    }
}

// Função para configurar o slider de preço
function setupPriceSlider() {
    const slider = document.querySelector(".price-slider");
    const priceRange = document.getElementById("priceRange");

    if (!slider || !priceRange) return;

    function updateSliderTrack() {
        const min = parseInt(slider.min);
        const max = parseInt(slider.max);
        const value = parseInt(slider.value);

        const percentage = ((value - min) / (max - min)) * 100;

        slider.style.background = `linear-gradient(to right, #ff6600 ${percentage}%, #ddd ${percentage}%)`;
        priceRange.textContent = `R$ 50 - R$ ${value}`;
    }

    slider.addEventListener("input", updateSliderTrack);
    
    // Aplicar filtro após o usuário parar de arrastar o slider
    let timeout;
    slider.addEventListener("change", function() {
        clearTimeout(timeout);
        timeout = setTimeout(applyFilters, 500);
    });

    // Atualizar ao carregar a página
    updateSliderTrack();
}

// ===========================================
// MOBILE FUNCTIONALITY
// ===========================================

// Mobile filter sidebar functions
function openMobileFilter() {
    const overlay = document.getElementById('mobileFilterOverlay');
    const sidebar = document.getElementById('mobileFilterSidebar');
    
    if (overlay && sidebar) {
        overlay.style.display = 'block';
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeMobileFilter() {
    const overlay = document.getElementById('mobileFilterOverlay');
    const sidebar = document.getElementById('mobileFilterSidebar');
    
    if (overlay && sidebar) {
        overlay.classList.remove('active');
        sidebar.classList.remove('active');
        
        setTimeout(() => {
            overlay.style.display = 'none';
        }, 300);
        
        document.body.style.overflow = '';
    }
}

// Mobile sort dropdown functions
function toggleMobileSortDropdown() {
    const dropdown = document.getElementById('mobileSortDropdown');
    if (dropdown) {
        dropdown.classList.toggle('active');
    }
}

function closeMobileSortDropdown() {
    const dropdown = document.getElementById('mobileSortDropdown');
    if (dropdown) {
        dropdown.classList.remove('active');
    }
}

// Mobile filter count update
function updateMobileFilterCount() {
    const countElement = document.getElementById('mobileFilterCount');
    if (!countElement) return;
    
    let count = 0;
    const urlFilters = getFiltersFromUrl();
    
    // Count active filters baseado na URL e no estado do formulário
    if (urlFilters.team) count++;
    if (urlFilters.season) count++;
    if (urlFilters.price_max) count++;
    if (urlFilters.size) count++;
    
    // Verificar checkboxes marcados
    const checkboxes = document.querySelectorAll('.filter input[type="checkbox"]:checked, #mobileFilterSidebar input[type="checkbox"]:checked');
    count += checkboxes.length;
    
    // Verificar dropdowns não padrão
    const sortSelect = document.getElementById('sortSelectOrdenar') || document.getElementById('mobileSortSelectOrdenar');
    if (sortSelect && sortSelect.dataset.sort && sortSelect.dataset.sort !== 'most_sold') {
        count++;
    }
    
    const productTypeSelect = document.getElementById('sortSelectTipo') || document.getElementById('mobileSortSelectTipo');
    if (productTypeSelect && productTypeSelect.dataset.productType && productTypeSelect.dataset.productType !== '') {
        count++;
    }
    
    countElement.textContent = count;
    countElement.style.display = count > 0 ? 'inline-block' : 'none';
}

// Função para obter filtros do formulário mobile
function getMobileFiltersFromForm() {
    const filters = {};
    
    // Get mobile filter values
    const mobilePriceSlider = document.getElementById('mobilePriceSlider');
    if (mobilePriceSlider && mobilePriceSlider.value && mobilePriceSlider.value !== '500') {
        filters.price_max = mobilePriceSlider.value;
    }
    
    // Get mobile dropdown values
    const mobileDropdowns = [
        { id: 'mobileSortSelectOrdenar', param: 'sort', dataAttr: 'sort' },
        { id: 'mobileSortSelectTime', param: 'team', dataAttr: 'team' },
        { id: 'mobileSortSelectTemporada', param: 'season', dataAttr: 'season' },
        { id: 'mobileSortSelectTipo', param: 'product_type', dataAttr: 'productType' }
    ];
    
    mobileDropdowns.forEach(dropdown => {
        const element = document.getElementById(dropdown.id);
        if (element && element.dataset[dropdown.dataAttr] !== undefined) {
            const value = element.dataset[dropdown.dataAttr];
            if (value && value !== '') {
                filters[dropdown.param] = value;
            }
        }
    });
    
    // Get mobile checkbox values
    const mobileCheckboxFilters = {
        'gender': document.querySelectorAll('#mobileFilterSidebar input[type="checkbox"][value="masculine"], #mobileFilterSidebar input[type="checkbox"][value="feminine"], #mobileFilterSidebar input[type="checkbox"][value="unisex"], #mobileFilterSidebar input[type="checkbox"][value="kids"]'),
        'size': document.querySelectorAll('#mobileFilterSidebar input[type="checkbox"][value="P"], #mobileFilterSidebar input[type="checkbox"][value="M"], #mobileFilterSidebar input[type="checkbox"][value="G"], #mobileFilterSidebar input[type="checkbox"][value="GG"]'),
        'category': document.querySelectorAll('#mobileFilterSidebar input[type="checkbox"][value="Retro"], #mobileFilterSidebar input[type="checkbox"][value="torcedor"], #mobileFilterSidebar input[type="checkbox"][value="jogador"], #mobileFilterSidebar input[type="checkbox"][value="treino"]'),
        'national_international': document.querySelectorAll('#mobileFilterSidebar input[type="checkbox"][value="Sim"], #mobileFilterSidebar input[type="checkbox"][value="Não"]')
    };
    
    Object.entries(mobileCheckboxFilters).forEach(([param, checkboxes]) => {
        const checkedValues = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        
        if (checkedValues.length > 0) {
            filters[param] = checkedValues.join(',');
        }
    });
    
    return filters;
}

// Mobile filter application
function applyMobileFilters() {
    const currentUrl = new URL(window.location);
    const filters = getMobileFiltersFromForm();
    
    // BasePath sempre será /camisas
    const basePath = '/camisas';
    
    // Gerar URL amigável
    const friendlyUrl = filtersToFriendlyUrl(filters, basePath);
    
    // Redirect with new filters
    window.location.href = friendlyUrl;
}

// Mobile sort application
function applyMobileSort(sortValue) {
    const currentUrl = new URL(window.location);
    
    // Obter filtros atuais da URL (se houver)
    const currentFilters = {};
    const basePath = '/camisas';
    
    // Processar segmentos da URL atual para manter outros filtros
    const pathSegments = currentUrl.pathname.split('/').filter(s => s);
    // Aqui poderia processar os segmentos, mas por simplicidade vamos apenas aplicar o sort
    
    if (sortValue && sortValue !== 'most_sold') {
        currentFilters.sort = sortValue;
    }
    
    const friendlyUrl = filtersToFriendlyUrl(currentFilters, basePath);
    window.location.href = friendlyUrl;
}

// Mobile price slider setup
function setupMobilePriceSlider() {
    const slider = document.getElementById('mobilePriceSlider');
    const priceRange = document.getElementById('mobilePriceRange');

    if (!slider || !priceRange) return;

    function updateMobileSliderTrack() {
        const min = parseInt(slider.min);
        const max = parseInt(slider.max);
        const value = parseInt(slider.value);

        const percentage = ((value - min) / (max - min)) * 100;

        slider.style.background = `linear-gradient(to right, #ff6600 ${percentage}%, #ddd ${percentage}%)`;
        priceRange.textContent = `R$ 50 - R$ ${value}`;
    }

    slider.addEventListener("input", updateMobileSliderTrack);
    updateMobileSliderTrack();
}

// Setup mobile dropdowns
function setupMobileDropdown(dropdownId, buttonId, dataAttribute) {
    const links = document.querySelectorAll(`#${dropdownId} a`);
    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const selectedText = this.textContent;
            const selectedValue = this.getAttribute(dataAttribute);
            const button = document.getElementById(buttonId);
            
            if (button) {
                button.childNodes[0].nodeValue = selectedText + " ";
                button.dataset[dataAttribute.replace('data-', '')] = selectedValue;
            }
            
            document.getElementById(dropdownId).style.display = "none";
        });
    });
}

// ===========================================
// INITIALIZATION
// ===========================================

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    // Configurar dropdowns desktop
    setupDropdown("dropdownMenu", "sortSelectOrdenar", "data-sort");
    setupDropdown("dropdownTemporada", "sortSelectTemporada", "data-season");
    setupDropdown("dropdownTime", "sortSelectTime", "data-team");
    setupDropdown("dropdownTipo", "sortSelectTipo", "data-product-type");

    // Configurar dropdowns mobile
    setupMobileDropdown("mobileDropdownMenu", "mobileSortSelectOrdenar", "data-sort");
    setupMobileDropdown("mobileDropdownTemporada", "mobileSortSelectTemporada", "data-season");
    setupMobileDropdown("mobileDropdownTime", "mobileSortSelectTime", "data-team");
    setupMobileDropdown("mobileDropdownTipo", "mobileSortSelectTipo", "data-product-type");

    // Adicionar listeners para checkboxes desktop
    document.querySelectorAll('.filter input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', applyFilters);
    });

    // Adicionar listeners para checkboxes mobile
    document.querySelectorAll('#mobileFilterSidebar input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            // Don't auto-apply on mobile, wait for user to click "Apply"
        });
    });

    // Configurar fechamento de dropdowns ao clicar fora
    document.addEventListener("click", function (event) {
        const allDropdowns = ["dropdownMenu", "dropdownTemporada", "dropdownTime", "dropdownTipo"];
        const allButtons = ["sortSelectOrdenar", "sortSelectTemporada", "sortSelectTime", "sortSelectTipo"];

        allDropdowns.forEach((id, index) => {
            const dropdown = document.getElementById(id);
            const button = document.getElementById(allButtons[index]);

            if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });
        
        // Close mobile sort dropdown
        if (!event.target.closest('.mobile-sort-bar')) {
            closeMobileSortDropdown();
        }
    });

    // Atualizar indicadores visuais
    updateActiveFilterIndicators();
    updateMobileFilterCount();
    
    // Inicializar o valor do time no dropdown se houver um filtro ativo na URL
    const urlFilters = getFiltersFromUrl();
    if (urlFilters.team) {
        const teamSelect = document.getElementById('sortSelectTime');
        const mobileTeamSelect = document.getElementById('mobileSortSelectTime');
        if (teamSelect) {
            teamSelect.dataset.team = urlFilters.team;
        }
        if (mobileTeamSelect) {
            mobileTeamSelect.dataset.team = urlFilters.team;
        }
    }
    
    // Adicionar listener para o botão de limpar filtros desktop
    const clearFiltersBtn = document.getElementById('clearFilters');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            window.location.href = '/camisas';
        });
    }

    // Configurar slider de preço desktop
    setupPriceSlider();
    
    // Configurar slider de preço mobile
    setupMobilePriceSlider();
    
    // ===========================================
    // MOBILE EVENT LISTENERS
    // ===========================================
    
    // Mobile filter toggle
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    if (mobileFilterToggle) {
        mobileFilterToggle.addEventListener('click', openMobileFilter);
    }
    
    // Mobile filter close
    const closeMobileFilterBtn = document.getElementById('closeMobileFilter');
    const mobileFilterOverlay = document.getElementById('mobileFilterOverlay');
    if (closeMobileFilterBtn) {
        closeMobileFilterBtn.addEventListener('click', closeMobileFilter);
    }
    if (mobileFilterOverlay) {
        mobileFilterOverlay.addEventListener('click', closeMobileFilter);
    }
    
    // Mobile filter actions
    const mobileClearFiltersBtn = document.getElementById('mobileClearFilters');
    const mobileApplyFiltersBtn = document.getElementById('mobileApplyFilters');
    
    if (mobileClearFiltersBtn) {
        mobileClearFiltersBtn.addEventListener('click', function() {
            window.location.href = '/camisas';
        });
    }
    
    if (mobileApplyFiltersBtn) {
        mobileApplyFiltersBtn.addEventListener('click', applyMobileFilters);
    }
    
    // Mobile sort toggle
    const mobileSortToggle = document.getElementById('mobileSortToggle');
    if (mobileSortToggle) {
        mobileSortToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleMobileSortDropdown();
        });
    }
    
    // Mobile sort options
    const mobileSortOptions = document.querySelectorAll('.mobile-sort-dropdown .sort-option');
    mobileSortOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const sortValue = this.getAttribute('data-sort');
            applyMobileSort(sortValue);
        });
    });
    
    // Close mobile filter on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeMobileFilter();
            closeMobileSortDropdown();
        }
    });
});
