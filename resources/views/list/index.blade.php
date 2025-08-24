@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/list.css') !!}">
@section('content')
    <div class="alignSection">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="#">Início</a></li>
                <li class="active">Camisetas</li>
            </ol>
        </nav>
    </div>
    <section class="listSection">
        <div class="alignSection">
            <h1>
                @if(isset($team))
                    Camisetas {{ $team['name'] }}
                @else
                    Camisetas
                @endif
            </h1>
            <div class="groupList">
                <div class="filter">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3>Filtrar por</h3>
                        <button id="clearFilters">Limpar Filtros</button>
                    </div>
                    <!-- Filtro por Preço -->
                    <div class="filter-group">
                        <h4>Preço</h4>
                        <input type="range" min="50" max="500" value="{{ $filters['price_max'] ?? 250 }}" class="price-slider" id="priceSlider">
                        <div class="price-range" id="priceRange">R$ 50 - R$ {{ $filters['price_max'] ?? 250 }}</div>
                    </div>

                    <!-- Ordenar por -->
                    <div class="filter-group">
                        <h4>Ordenar por</h4>
                        <div class="sort-select" id="sortSelectOrdenar" onclick="toggleDropdown('dropdownMenu')">
                            @switch($filters['sort'] ?? 'most_sold')
                                @case('newest')
                                    Novidades
                                    @break
                                @case('promotions')
                                    Promoções
                                    @break
                                @case('price_asc')
                                    Preço: menor para maior
                                    @break
                                @case('price_desc')
                                    Preço: maior para menor
                                    @break
                                @default
                                    Mais vendidos
                            @endswitch
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownMenu">
                                <a href="#" data-sort="most_sold">Mais vendidos</a>
                                <a href="#" data-sort="newest">Novidades</a>
                                <a href="#" data-sort="promotions">Promoções</a>
                                <a href="#" data-sort="price_asc">Preço: menor para maior</a>
                                <a href="#" data-sort="price_desc">Preço: maior para menor</a>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h4>Time</h4>
                        <div class="sort-select" id="sortSelectTime" onclick="toggleDropdown('dropdownTime')">
                            @if(isset($filters['team']) && $filters['team'])
                                @php
                                    $selectedTeam = collect($teams)->firstWhere('url', $filters['team']);
                                    $teamName = $selectedTeam ? $selectedTeam['name'] : 'Time';
                                @endphp
                                {{ $teamName }}
                            @else
                                Time
                            @endif
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTime">
                                @if(isset($teams) && count($teams) > 0)
                                    @foreach($teams as $team)
                                        <a href="#" data-team="{{ $team['url'] }}">{{ $team['name'] }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="filter-group checkbox">
                        <h4>Gênero</h4>
                        <label>
                            <input type="checkbox" value="masculine" {{ in_array('masculine', explode(',', $filters['gender'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Masculino
                        </label>
                        <label>
                            <input type="checkbox" value="feminine" {{ in_array('feminine', explode(',', $filters['gender'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Feminino
                        </label>
                        <label>
                            <input type="checkbox" value="unisex" {{ in_array('unisex', explode(',', $filters['gender'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Unisex
                        </label>
                        <label>
                            <input type="checkbox" value="kids" {{ in_array('kids', explode(',', $filters['gender'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Infantil
                        </label>
                    </div>

                    <!-- Filtro por Tamanho -->
                    <div class="filter-group checkbox">
                        <h4>Tamanho</h4>
                        <label>
                            <input type="checkbox" value="P" {{ in_array('P', explode(',', $filters['size'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            P
                        </label>
                        <label>
                            <input type="checkbox" value="M" {{ in_array('M', explode(',', $filters['size'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            M
                        </label>
                        <label>
                            <input type="checkbox" value="G" {{ in_array('G', explode(',', $filters['size'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            G
                        </label>
                        <label>
                            <input type="checkbox" value="GG" {{ in_array('GG', explode(',', $filters['size'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            GG
                        </label>
                    </div>

                    <!-- Temporada -->
                    <div class="filter-group">
                        <h4>Temporada</h4>
                        <div class="sort-select" id="sortSelectTemporada" onclick="toggleDropdown('dropdownTemporada')">
                            {{ $filters['season'] ?? 'Selecione' }}
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTemporada">
                                @php
                                    $currentYear = date('Y');
                                    for ($year = $currentYear; $year >= 2010; $year--) {
                                        $value = substr($year, 2);
                                        $nextYear = substr($year + 1, 2);
                                        $season = $value . '/' . $nextYear;
                                        echo '<a href="#" data-season="' . $season . '">' . $season . '</a>';
                                    }
                                @endphp
                            </div>
                        </div>
                    </div>

                    <div class="filter-group checkbox">
                        <h4>Categoria</h4>
                        <label>
                            <input type="checkbox" value="Retro" {{ in_array('Retro', explode(',', $filters['category'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Retro
                        </label>
                    </div>
                    <div class="filter-group checkbox">
                        <h4>Nacional / Internacional</h4>
                        <label>
                            <input type="checkbox" value="Sim" {{ in_array('Sim', explode(',', $filters['national_international'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Nacional
                        </label>
                        <label>
                            <input type="checkbox" value="Não" {{ in_array('Não', explode(',', $filters['national_international'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Internacional
                        </label>
                    </div>

                    <div class="filter-group">
                        <h4>Tipo de produto</h4>
                        <div class="sort-select" id="sortSelectTipo" onclick="toggleDropdown('dropdownTipo')">
                            @switch($filters['product_type'] ?? 'uniforme')
                                @case('casual')
                                    Casual
                                    @break
                                @case('acessorios')
                                    Acessórios
                                    @break
                                @default
                                    Uniforme
                            @endswitch
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTipo">
                                <a href="#" data-product-type="uniforme">Uniforme</a>
                                <a href="#" data-product-type="casual">Casual</a>
                                <a href="#" data-product-type="acessorios">Acessórios</a>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group checkbox">
                        <h4>Tipo de Camisa</h4>
                        <label>
                            <input type="checkbox" value="torcedor" {{ in_array('torcedor', explode(',', $filters['category'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Torcedor
                        </label>
                        <label>
                            <input type="checkbox" value="jogador" {{ in_array('jogador', explode(',', $filters['category'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Jogador
                        </label>
                        <label>
                            <input type="checkbox" value="treino" {{ in_array('treino', explode(',', $filters['category'] ?? '')) ? 'checked' : '' }} />
                            <span class="custom-checkbox"></span>
                            Treino
                        </label>
                    </div>

                </div>

                <div class="productList">
                    @if(isset($products) && count($products) > 0)
                        <div style="margin-bottom: 20px; color: #666; font-size: 14px;">
                            {{ $total }} produto{{ $total > 1 ? 's' : '' }} encontrado{{ $total > 1 ? 's' : '' }}
                            @if(isset($filters) && array_filter($filters))
                                com os filtros aplicados
                            @endif
                        </div>
                        <div class="grid">
                            @foreach($products as $product)
                                <div class="card">
                                    <a href="{{ $product['url'] }}" class="card-link">
                                        <div class="cardContent">
                                            @if($product['discount_percentage'])
                                                <span class="badge">{{ $product['discount_percentage'] }}</span>
                                            @endif
                                            <img
                                                src="{{ $product['image'] ?? asset('images/placeholder-product.jpg') }}"
                                                alt="{{ $product['name'] }}">
                                        </div>
                                        <div class="info">
                                            <h3>{{ $product['name'] }}</h3>
                                            <div>
                                                <span class="price">{{ $product['price'] }}</span>
                                                @if($product['special_price'])
                                                    <span class="old-price">{{ $product['special_price'] }}</span>
                                                @endif
                                            </div>
                                            <div>{{ $product['installment_price'] }}</div>
                                            <div class="stars">★★★★★ (5)</div>
                                            <span class="free-shipping">FRETE GRÁTIS</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($lastPage > 1)
                            <div class="pagination">
                                @if($currentPage > 1)
                                    <a href="?{{ http_build_query(array_merge($filters, ['page' => $currentPage - 1])) }}" class="page-link">Anterior</a>
                                @endif
                                
                                @for($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
                                    <a href="?{{ http_build_query(array_merge($filters, ['page' => $i])) }}" 
                                       class="page-link {{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
                                @endfor
                                
                                @if($currentPage < $lastPage)
                                    <a href="?{{ http_build_query(array_merge($filters, ['page' => $currentPage + 1])) }}" class="page-link">Próxima</a>
                                @endif
                            </div>
                        @endif
                    @else
                        <div class="no-products">
                            <h3>Nenhum produto encontrado</h3>
                            <p>Tente ajustar os filtros ou fazer uma nova busca.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <script>
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
                if (teamSelect.dataset.team) {
                    params.set('team', teamSelect.dataset.team);
                } else {
                    params.delete('team');
                }
            }
            
            // Filtro de temporada
            const seasonSelect = document.getElementById('sortSelectTemporada');
            if (seasonSelect && seasonSelect.dataset.season) {
                params.set('season', seasonSelect.dataset.season);
            }
            
            // Filtro de tipo de produto
            const productTypeSelect = document.getElementById('sortSelectTipo');
            if (productTypeSelect && productTypeSelect.dataset.productType) {
                params.set('product_type', productTypeSelect.dataset.productType);
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

        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        document.addEventListener("click", function (event) {
            const allDropdowns = ["dropdownMenu", "dropdownTemporada", "dropdownTime", "dropdownTipo"];
            const allButtons = ["sortSelectOrdenar", "sortSelectTemporada", "sortSelectTime", "sortSelectTipo"];

            allDropdowns.forEach((id, index) => {
                const dropdown = document.getElementById(id);
                const button = document.getElementById(allButtons[index]);

                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.style.display = "none";
                }
            });
        });

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

        setupDropdown("dropdownMenu", "sortSelectOrdenar", "data-sort");
        setupDropdown("dropdownTemporada", "sortSelectTemporada", "data-season");
        setupDropdown("dropdownTime", "sortSelectTime", "data-team");
        setupDropdown("dropdownTipo", "sortSelectTipo", "data-product-type");

        // Adicionar listeners para checkboxes
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', applyFilters);
        });

        // Função para atualizar indicadores visuais de filtros ativos
        function updateActiveFilterIndicators() {
            // Atualizar indicadores de checkboxes
            document.querySelectorAll('.filter-group.checkbox').forEach(group => {
                const checkboxes = group.querySelectorAll('input[type="checkbox"]');
                const hasActiveFilters = Array.from(checkboxes).some(cb => cb.checked);
                
                if (hasActiveFilters) {
                    group.classList.add('has-active-filters');
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
                
                if (currentValue && currentValue !== 'most_sold' && currentValue !== '2023/24' && currentValue !== 'uniforme') {
                    element.classList.add('active');
                } else {
                    element.classList.remove('active');
                }
            });

            // Atualizar indicador do slider de preço
            const priceSlider = document.getElementById('priceSlider');
            const currentPriceMax = new URLSearchParams(window.location.search).get('price_max');
            if (priceSlider && currentPriceMax && currentPriceMax !== '250') {
                priceSlider.parentElement.classList.add('has-active-filters');
            } else {
                priceSlider.parentElement.classList.remove('has-active-filters');
            }
        }

        // Chamar a função ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            updateActiveFilterIndicators();
            
            // Inicializar o valor do time no dropdown se houver um filtro ativo
            const currentTeam = new URLSearchParams(window.location.search).get('team');
            if (currentTeam) {
                const teamSelect = document.getElementById('sortSelectTime');
                if (teamSelect) {
                    teamSelect.dataset.team = currentTeam;
                }
            }
            
            // Adicionar listener para o botão de limpar filtros
            const clearFiltersBtn = document.getElementById('clearFilters');
            if (clearFiltersBtn) {
                clearFiltersBtn.addEventListener('click', function() {
                    // Redirecionar para a URL base sem parâmetros
                    const currentUrl = new URL(window.location);
                    window.location.href = currentUrl.pathname;
                });
            }
        });

        // Adicionar listener para o slider de preço
        document.addEventListener("DOMContentLoaded", function () {
            const slider = document.querySelector(".price-slider");
            const priceRange = document.getElementById("priceRange");

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
        });
    </script>
@endsection
