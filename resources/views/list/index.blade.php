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
            
            <!-- Mobile Sort Bar -->
            <div class="mobile-sort-bar">
                <div class="sort-container">
                    <div class="results-count">
                        @if(isset($products) && count($products) > 0)
                            {{ $total }} produto{{ $total > 1 ? 's' : '' }} encontrado{{ $total > 1 ? 's' : '' }}
                        @endif
                    </div>
                    <button class="mobile-filter-toggle" id="mobileFilterToggle">
                        <span class="filter-icon">🔍</span>
                        Filtros
                        <span class="filter-count" id="mobileFilterCount">0</span>
                    </button>
                </div>
                
            </div>
            
            <div class="groupList">
                <div class="filter">
                    <div class="filter-header">
                        <h3>Filtrar por</h3>
                        <button id="clearFilters" class="clear-filters-btn">Limpar Filtros</button>
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
                                    $teamName = $selectedTeam ? $selectedTeam['name'] : 'Todos';
                                @endphp
                                {{ $teamName }}
                            @else
                                Todos
                            @endif
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTime">
                                <a href="#" data-team="">Todos</a>
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
                            {{ $filters['season'] ?? 'Todos' }}
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTemporada">
                                <a href="#" data-season="">Todos</a>
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
                            @switch($filters['product_type'] ?? '')
                                @case('casual')
                                    Casual
                                    @break
                                @case('acessorios')
                                    Acessórios
                                    @break
                                @case('uniforme')
                                    Uniforme
                                    @break
                                @default
                                    Todos
                            @endswitch
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTipo">
                                <a href="#" data-product-type="">Todos</a>
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
                        <!-- Desktop product count (hidden on mobile) -->
                        <div class="desktop-product-count" style="margin-bottom: 20px; color: #666; font-size: 14px;">
                            {{ $total }} produto{{ $total > 1 ? 's' : '' }} encontrado{{ $total > 1 ? 's' : '' }}
                            @if(isset($filters) && array_filter($filters))
                                com os filtros aplicados
                            @endif
                        </div>
                        
                        <!-- Desktop Grid -->
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
                        
                        <!-- Mobile Grid -->
                        <div class="mobile-product-grid">
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
    
    <!-- Mobile Filter Components -->
    <div class="mobile-filter-overlay" id="mobileFilterOverlay"></div>
    
    <!-- Mobile Filter Sidebar -->
    <div class="mobile-filter-sidebar" id="mobileFilterSidebar">
        <div class="mobile-filter-header">
            <h3>Filtrar por</h3>
            <button class="close-filter" id="closeMobileFilter">×</button>
        </div>
        
        <div class="mobile-filter-content">
            <!-- Filtro por Preço -->
            <div class="filter-group">
                <h4>Preço</h4>
                <input type="range" min="50" max="500" value="{{ $filters['price_max'] ?? 250 }}" class="price-slider" id="mobilePriceSlider">
                <div class="price-range" id="mobilePriceRange">R$ 50 - R$ {{ $filters['price_max'] ?? 250 }}</div>
            </div>

            <!-- Ordenar por -->
            <div class="filter-group">
                <h4>Ordenar por</h4>
                <div class="sort-select" id="mobileSortSelectOrdenar" onclick="toggleDropdown('mobileDropdownMenu')">
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
                    <div class="dropdown-content" id="mobileDropdownMenu">
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
                <div class="sort-select" id="mobileSortSelectTime" onclick="toggleDropdown('mobileDropdownTime')">
                    @if(isset($filters['team']) && $filters['team'])
                        @php
                            $selectedTeam = collect($teams)->firstWhere('url', $filters['team']);
                            $teamName = $selectedTeam ? $selectedTeam['name'] : 'Todos';
                        @endphp
                        {{ $teamName }}
                    @else
                        Todos
                    @endif
                    <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                        <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                    </svg>
                </div>
                <div class="dropdown">
                    <div class="dropdown-content" id="mobileDropdownTime">
                        <a href="#" data-team="">Todos</a>
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
                <div class="sort-select" id="mobileSortSelectTemporada" onclick="toggleDropdown('mobileDropdownTemporada')">
                    {{ $filters['season'] ?? 'Todos' }}
                    <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                        <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                    </svg>
                </div>
                <div class="dropdown">
                    <div class="dropdown-content" id="mobileDropdownTemporada">
                        <a href="#" data-season="">Todos</a>
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
                <div class="sort-select" id="mobileSortSelectTipo" onclick="toggleDropdown('mobileDropdownTipo')">
                    @switch($filters['product_type'] ?? '')
                        @case('casual')
                            Casual
                            @break
                        @case('acessorios')
                            Acessórios
                            @break
                        @case('uniforme')
                            Uniforme
                            @break
                        @default
                            Todos
                    @endswitch
                    <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                        <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                    </svg>
                </div>
                <div class="dropdown">
                    <div class="dropdown-content" id="mobileDropdownTipo">
                        <a href="#" data-product-type="">Todos</a>
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
        
        <div class="mobile-filter-actions">
            <button class="btn btn-clear" id="mobileClearFilters">Limpar</button>
            <button class="btn btn-apply" id="mobileApplyFilters">Aplicar</button>
        </div>
    </div>
    
    
    <script src="{!! asset('assets/js/list.min.js') !!}"></script>
@endsection
