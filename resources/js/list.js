// Função para alternar dropdowns (deve estar no escopo global)
function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
}

// Expor a função no escopo global para uso em onclick
window.toggleDropdown = toggleDropdown;

// Função para aplicar filtros
function applyFilters() {
    const currentUrl = new URL(window.location);
    const params = new URLSearchParams(currentUrl.search);
    
    // Limpar parâmetros de página ao aplicar filtros
    params.delete('page');
    
    // Filtro de preço
    const priceSlider = document.getElementById('priceSlider');
    if (priceSlider) {
        params.set('price_max', priceSlider.value);
    }
    
    // Filtro de ordenação
    const sortSelect = document.getElementById('sortSelectOrdenar');
    if (sortSelect && sortSelect.dataset.sort) {
        params.set('sort', sortSelect.dataset.sort);
    }
    
    // Filtro de time
    const teamSelect = document.getElementById('sortSelectTime');
    if (teamSelect && teamSelect.dataset.team !== undefined) {
        if (teamSelect.dataset.team && teamSelect.dataset.team !== '') {
            params.set('team', teamSelect.dataset.team);
        } else {
            params.delete('team');
        }
    }
    
    // Filtro de temporada
    const seasonSelect = document.getElementById('sortSelectTemporada');
    if (seasonSelect && seasonSelect.dataset.season !== undefined) {
        if (seasonSelect.dataset.season && seasonSelect.dataset.season !== '') {
            params.set('season', seasonSelect.dataset.season);
        } else {
            params.delete('season');
        }
    }
    
    // Filtro de tipo de produto
    const productTypeSelect = document.getElementById('sortSelectTipo');
    if (productTypeSelect && productTypeSelect.dataset.productType !== undefined) {
        if (productTypeSelect.dataset.productType && productTypeSelect.dataset.productType !== '') {
            params.set('product_type', productTypeSelect.dataset.productType);
        } else {
            params.delete('product_type');
        }
    }
    
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
            params.set(param, checkedValues.join(','));
        } else {
            params.delete(param);
        }
    });
    
    
    // Redirecionar com os novos filtros
    window.location.href = currentUrl.pathname + '?' + params.toString();
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

// Função para atualizar indicadores visuais de filtros ativos
function updateActiveFilterIndicators() {
    let hasAnyActiveFilters = false;

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

    // Atualizar indicadores de dropdowns
    const dropdowns = [
        { id: 'sortSelectOrdenar', param: 'sort' },
        { id: 'sortSelectTime', param: 'team' },
        { id: 'sortSelectTemporada', param: 'season' },
        { id: 'sortSelectTipo', param: 'product_type' }
    ];

    dropdowns.forEach(dropdown => {
        const element = document.getElementById(dropdown.id);
        const currentValue = new URLSearchParams(window.location.search).get(dropdown.param);
        
        // Considerar ativo apenas se houver valor e não for o valor padrão
        const isActive = currentValue && 
                        currentValue !== '' && 
                        currentValue !== 'most_sold' && 
                        currentValue !== '2023/24' && 
                        currentValue !== 'uniforme';
        
        if (isActive) {
            element.classList.add('active');
            hasAnyActiveFilters = true;
        } else {
            element.classList.remove('active');
        }
    });

    // Atualizar indicador do slider de preço
    const priceSlider = document.getElementById('priceSlider');
    const currentPriceMax = new URLSearchParams(window.location.search).get('price_max');
    if (priceSlider && currentPriceMax && currentPriceMax !== '250') {
        priceSlider.parentElement.classList.add('has-active-filters');
        hasAnyActiveFilters = true;
    } else {
        priceSlider.parentElement.classList.remove('has-active-filters');
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
    const urlParams = new URLSearchParams(window.location.search);
    
    // Count active filters
    const filterParams = ['sort', 'team', 'season', 'product_type', 'price_max', 'gender', 'size', 'category', 'national_international'];
    
    filterParams.forEach(param => {
        const value = urlParams.get(param);
        if (value && value !== '' && value !== 'most_sold' && value !== '250') {
            count++;
        }
    });
    
    countElement.textContent = count;
    countElement.style.display = count > 0 ? 'inline-block' : 'none';
}

// Mobile filter application
function applyMobileFilters() {
    const currentUrl = new URL(window.location);
    const params = new URLSearchParams(currentUrl.search);
    
    // Clear page parameter
    params.delete('page');
    
    // Get mobile filter values
    const mobilePriceSlider = document.getElementById('mobilePriceSlider');
    if (mobilePriceSlider) {
        params.set('price_max', mobilePriceSlider.value);
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
                params.set(dropdown.param, value);
            } else {
                params.delete(dropdown.param);
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
            params.set(param, checkedValues.join(','));
        } else {
            params.delete(param);
        }
    });
    
    // Redirect with new filters
    window.location.href = currentUrl.pathname + '?' + params.toString();
}

// Mobile sort application
function applyMobileSort(sortValue) {
    const currentUrl = new URL(window.location);
    const params = new URLSearchParams(currentUrl.search);
    
    if (sortValue && sortValue !== 'most_sold') {
        params.set('sort', sortValue);
    } else {
        params.delete('sort');
    }
    
    params.delete('page');
    
    window.location.href = currentUrl.pathname + '?' + params.toString();
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
    
    // Inicializar o valor do time no dropdown se houver um filtro ativo
    const currentTeam = new URLSearchParams(window.location.search).get('team');
    if (currentTeam) {
        const teamSelect = document.getElementById('sortSelectTime');
        const mobileTeamSelect = document.getElementById('mobileSortSelectTime');
        if (teamSelect) {
            teamSelect.dataset.team = currentTeam;
        }
        if (mobileTeamSelect) {
            mobileTeamSelect.dataset.team = currentTeam;
        }
    }
    
    // Adicionar listener para o botão de limpar filtros desktop
    const clearFiltersBtn = document.getElementById('clearFilters');
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', function() {
            const currentUrl = new URL(window.location);
            window.location.href = currentUrl.pathname;
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
            const currentUrl = new URL(window.location);
            window.location.href = currentUrl.pathname;
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
