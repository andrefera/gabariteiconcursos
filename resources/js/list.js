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

function extractCheckboxFilters(container) {
    const filters = {};

    if (!container) {
        return filters;
    }

    const checkboxes = container.querySelectorAll('input[type="checkbox"][data-filter-group]');
    const grouped = {};

    checkboxes.forEach((checkbox) => {
        const group = checkbox.dataset.filterGroup;
        if (!group) {
            return;
        }

        if (!grouped[group]) {
            grouped[group] = [];
        }

        grouped[group].push(checkbox);
    });

    Object.entries(grouped).forEach(([group, items]) => {
        const checkedValues = items
            .filter((checkbox) => checkbox.checked)
            .map((checkbox) => checkbox.value);

        if (checkedValues.length > 0) {
            const uniqueValues = Array.from(new Set(checkedValues));
            filters[group] = uniqueValues.join(',');
        }
    });

    return filters;
}

function isSliderActive(slider) {
    if (!slider) {
        return false;
    }

    const currentValue = slider.value ?? '';
    const defaultValue = slider.dataset.default ?? slider.getAttribute('max') ?? '';

    if (currentValue === '') {
        return false;
    }

    return currentValue !== defaultValue;
}

function collectActiveFilters({ container, sliderId, dropdowns = [] }) {
    const activeSet = new Set();

    if (container) {
        container.querySelectorAll('input[type="checkbox"][data-filter-group]:checked').forEach((checkbox) => {
            const group = checkbox.dataset.filterGroup;
            const value = checkbox.dataset.filterValue ?? checkbox.value;

            if (group && value !== undefined) {
                activeSet.add(`${group}:${value}`);
            }
        });
    }

    if (sliderId) {
        const slider = document.getElementById(sliderId);
        if (slider && isSliderActive(slider)) {
            activeSet.add(`${sliderId}:value`);
        }
    }

    dropdowns.forEach(({ id, datasetKey, defaultValue = '', key }) => {
        const element = document.getElementById(id);
        if (!element) {
            return;
        }

        const value = element.dataset[datasetKey] ?? '';
        if (value && value !== defaultValue) {
            activeSet.add(`${key}:${value}`);
        }
    });

    return activeSet;
}

function syncLinkedCheckboxes(changedCheckbox) {
    if (!changedCheckbox || !changedCheckbox.dataset) {
        return;
    }

    const group = changedCheckbox.dataset.filterGroup;
    const value = changedCheckbox.dataset.filterValue ?? changedCheckbox.value;

    if (!group || value === undefined) {
        return;
    }

    document.querySelectorAll(`input[type="checkbox"][data-filter-group="${group}"]`).forEach((checkbox) => {
        if (checkbox === changedCheckbox) {
            return;
        }

        const checkboxValue = checkbox.dataset.filterValue ?? checkbox.value;
        if (checkboxValue === value) {
            checkbox.checked = changedCheckbox.checked;
        }
    });
}

function dataAttributeToDatasetKey(dataAttribute) {
    return dataAttribute
        .replace(/^data-/, '')
        .split('-')
        .map((part, index) => (index === 0 ? part : part.charAt(0).toUpperCase() + part.slice(1)))
        .join('');
}

// Função para obter todos os filtros do formulário
function getFiltersFromForm() {
    const filters = extractCheckboxFilters(document.querySelector('.filter'));

    const priceSlider = document.getElementById('priceSlider');
    if (priceSlider && isSliderActive(priceSlider)) {
        filters.price_max = priceSlider.value;
    }

    const sortSelect = document.getElementById('sortSelectOrdenar');
    if (sortSelect) {
        const sortValue = sortSelect.dataset.sort ?? 'most_sold';
        if (sortValue && sortValue !== 'most_sold') {
            filters.sort = sortValue;
        }
    }

    const teamSelect = document.getElementById('sortSelectTime');
    if (teamSelect) {
        const teamValue = teamSelect.dataset.team ?? '';
        if (teamValue) {
            filters.team = teamValue;
        }
    }

    const seasonSelect = document.getElementById('sortSelectTemporada');
    if (seasonSelect) {
        const seasonValue = seasonSelect.dataset.season ?? '';
        if (seasonValue) {
            filters.season = seasonValue;
        }
    }

    const productTypeSelect = document.getElementById('sortSelectTipo');
    if (productTypeSelect) {
        const productTypeValue = productTypeSelect.dataset.productType ?? '';
        if (productTypeValue) {
            filters.product_type = productTypeValue;
        }
    }

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
            const datasetKey = dataAttributeToDatasetKey(dataAttribute);
            button.dataset[datasetKey] = selectedValue;
            
            document.getElementById(dropdownId).style.display = "none";
            updateActiveFilterIndicators();
            updateMobileFilterCount();
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
    const filterContainer = document.querySelector('.filter');
    const activeSet = collectActiveFilters({
        container: filterContainer,
        sliderId: 'priceSlider',
        dropdowns: [
            { id: 'sortSelectOrdenar', datasetKey: 'sort', defaultValue: 'most_sold', key: 'sort' },
            { id: 'sortSelectTime', datasetKey: 'team', defaultValue: '', key: 'team' },
            { id: 'sortSelectTemporada', datasetKey: 'season', defaultValue: '', key: 'season' },
            { id: 'sortSelectTipo', datasetKey: 'productType', defaultValue: '', key: 'product_type' }
        ]
    });

    const activeCount = activeSet.size;

    document.querySelectorAll('.filter-group.checkbox').forEach((group) => {
        const hasChecked = group.querySelector('input[type="checkbox"][data-filter-group]:checked');
        group.classList.toggle('has-active-filters', !!hasChecked);
    });

    const priceSlider = document.getElementById('priceSlider');
    if (priceSlider) {
        const sliderWrapper = priceSlider.parentElement;
        if (sliderWrapper) {
            sliderWrapper.classList.toggle('has-active-filters', isSliderActive(priceSlider));
        }
    }

    ['sortSelectOrdenar', 'sortSelectTime', 'sortSelectTemporada', 'sortSelectTipo'].forEach((id) => {
        const element = document.getElementById(id);
        if (!element) {
            return;
        }

        const datasetKeys = {
            sortSelectOrdenar: { key: 'sort', defaultValue: 'most_sold' },
            sortSelectTime: { key: 'team', defaultValue: '' },
            sortSelectTemporada: { key: 'season', defaultValue: '' },
            sortSelectTipo: { key: 'productType', defaultValue: '' }
        };

        const { key, defaultValue } = datasetKeys[id];
        const value = element.dataset[key] ?? '';
        element.classList.toggle('active', !!value && value !== defaultValue);
    });

    const clearFiltersBtn = document.getElementById('clearFilters');
    if (clearFiltersBtn) {
        const isActive = activeCount > 0;
        clearFiltersBtn.disabled = !isActive;
        clearFiltersBtn.classList.toggle('is-active', isActive);
    }

    updateMobileFilterCount();
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
        updateActiveFilterIndicators();
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

    const desktopSet = collectActiveFilters({
        container: document.querySelector('.filter'),
        sliderId: 'priceSlider',
        dropdowns: [
            { id: 'sortSelectOrdenar', datasetKey: 'sort', defaultValue: 'most_sold', key: 'sort' },
            { id: 'sortSelectTime', datasetKey: 'team', defaultValue: '', key: 'team' },
            { id: 'sortSelectTemporada', datasetKey: 'season', defaultValue: '', key: 'season' },
            { id: 'sortSelectTipo', datasetKey: 'productType', defaultValue: '', key: 'product_type' }
        ]
    });

    const mobileSet = collectActiveFilters({
        container: document.getElementById('mobileFilterSidebar'),
        sliderId: 'mobilePriceSlider',
        dropdowns: [
            { id: 'mobileSortSelectOrdenar', datasetKey: 'sort', defaultValue: 'most_sold', key: 'sort' },
            { id: 'mobileSortSelectTime', datasetKey: 'team', defaultValue: '', key: 'team' },
            { id: 'mobileSortSelectTemporada', datasetKey: 'season', defaultValue: '', key: 'season' },
            { id: 'mobileSortSelectTipo', datasetKey: 'productType', defaultValue: '', key: 'product_type' }
        ]
    });

    const combinedSet = new Set([...desktopSet, ...mobileSet]);

    const activeCount = combinedSet.size;
    countElement.textContent = activeCount;
    countElement.style.display = activeCount > 0 ? 'inline-block' : 'none';
}

// Função para obter filtros do formulário mobile
function getMobileFiltersFromForm() {
    const mobileContainer = document.getElementById('mobileFilterSidebar');
    const filters = extractCheckboxFilters(mobileContainer);

    const mobilePriceSlider = document.getElementById('mobilePriceSlider');
    if (mobilePriceSlider && isSliderActive(mobilePriceSlider)) {
        filters.price_max = mobilePriceSlider.value;
    }

    const mobileDropdowns = [
        { id: 'mobileSortSelectOrdenar', param: 'sort', datasetKey: 'sort', defaultValue: 'most_sold' },
        { id: 'mobileSortSelectTime', param: 'team', datasetKey: 'team', defaultValue: '' },
        { id: 'mobileSortSelectTemporada', param: 'season', datasetKey: 'season', defaultValue: '' },
        { id: 'mobileSortSelectTipo', param: 'product_type', datasetKey: 'productType', defaultValue: '' }
    ];

    mobileDropdowns.forEach(({ id, param, datasetKey, defaultValue }) => {
        const element = document.getElementById(id);
        if (!element) {
            return;
        }

        const value = element.dataset[datasetKey] ?? '';
        if (value && value !== defaultValue) {
            filters[param] = value;
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
        updateMobileFilterCount();
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
                const datasetKey = dataAttributeToDatasetKey(dataAttribute);
                button.dataset[datasetKey] = selectedValue;
            }
            
            document.getElementById(dropdownId).style.display = "none";
            updateMobileFilterCount();
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
    document.querySelectorAll('.filter input[type="checkbox"][data-filter-group]').forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            syncLinkedCheckboxes(this);
            updateActiveFilterIndicators();
            updateMobileFilterCount();
            applyFilters();
        });
    });

    // Adicionar listeners para checkboxes mobile
    document.querySelectorAll('#mobileFilterSidebar input[type="checkbox"][data-filter-group]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            syncLinkedCheckboxes(this);
            updateMobileFilterCount();
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
