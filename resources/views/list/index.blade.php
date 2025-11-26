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

            @php
                $availableFilters = $availableFilters ?? [];
                $availableTeamsCounts = $availableFilters['team'] ?? [];
                $availableSeasonCounts = $availableFilters['season'] ?? [];
                $availableGenderCounts = $availableFilters['gender'] ?? [];
                $availableCategoryCounts = $availableFilters['category'] ?? [];
                $availableSizeCounts = $availableFilters['size'] ?? [];
                $availableTypeCounts = $availableFilters['product_type'] ?? [];
                $availableNationalCounts = $availableFilters['national_international'] ?? [];

                $selectedTeam = $filters['team'] ?? null;
                $selectedSeason = $filters['season'] ?? null;
                $selectedProductType = $filters['product_type'] ?? null;

                $selectedGender = array_values(array_filter(array_map('trim', explode(',', $filters['gender'] ?? ''))));
                $selectedSizes = array_values(array_filter(array_map('trim', explode(',', $filters['size'] ?? ''))));
                $selectedCategories = array_values(array_filter(array_map('trim', explode(',', $filters['category'] ?? ''))));
                $selectedNational = array_values(array_filter(array_map('trim', explode(',', $filters['national_international'] ?? ''))));

                $teamOptions = collect($teams ?? [])->filter(function ($teamOption) use ($availableTeamsCounts, $selectedTeam) {
                    $url = $teamOption['url'] ?? null;
                    if (!$url) {
                        return false;
                    }

                    return ($availableTeamsCounts[$url] ?? 0) > 0 || $selectedTeam === $url;
                })->values();

                $seasonOptions = collect(array_keys($availableSeasonCounts))
                    ->when($selectedSeason && !isset($availableSeasonCounts[$selectedSeason]), function ($collection) use ($selectedSeason) {
                        return $collection->prepend($selectedSeason);
                    })
                    ->unique()
                    ->sortDesc()
                    ->values();

                $genderLabels = [
                    'masculine' => 'Masculino',
                    'feminine' => 'Feminino',
                    'unisex' => 'Unisex',
                    'kids' => 'Infantil',
                ];

                $categoryLabels = [
                    'Retro' => 'Retro',
                    'Seleção' => 'Seleção',
                    'torcedor' => 'Torcedor',
                    'jogador' => 'Jogador',
                    'treino' => 'Treino',
                ];

                $primaryCategoryKeys = ['Retro', 'Seleção'];
                $shirtCategoryKeys = ['torcedor', 'jogador', 'treino'];

                $productTypeLabels = [
                    '' => 'Todos',
                    'uniforme' => 'Uniforme',
                    'casual' => 'Casual',
                    'acessorios' => 'Acessórios',
                ];

                $sizeLabels = [
                    'P' => 'P',
                    'M' => 'M',
                    'G' => 'G',
                    'GG' => 'GG',
                ];

                $nationalityLabels = [
                    'Sim' => 'Nacional',
                    'Não' => 'Internacional',
                ];
            @endphp
            
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
                        <div class="filter-header-title">
                            <h3>Filtrar por</h3>
                        </div>
                        <button id="clearFilters" class="clear-filters-btn" type="button" disabled>
                            <span class="icon" aria-hidden="true">⟳</span>
                            <span class="text">
                                <strong>Limpar filtros</strong>
                                <small>Voltar para todos os produtos</small>
                            </span>
                        </button>
                    </div>
                    <!-- Filtro por Preço -->
                    <div class="filter-group" style="display: none;">
                        <h4>Preço</h4>
                        <input
                            type="range"
                            min="50"
                            max="500"
                            value="{{ $filters['price_max'] ?? 500 }}"
                            data-default="500"
                            class="price-slider"
                            id="priceSlider"
                        >
                        <div class="price-range" id="priceRange">R$ 50 - R$ {{ $filters['price_max'] ?? 500 }}</div>
                    </div>

                    <!-- Ordenar por -->
                    <div class="filter-group">
                        <h4>Ordenar por</h4>
                        <div
                            class="sort-select"
                            id="sortSelectOrdenar"
                            data-sort="{{ $filters['sort'] ?? 'most_sold' }}"
                            onclick="toggleDropdown('dropdownMenu')"
                        >
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
                        <div
                            class="sort-select"
                            id="sortSelectTime"
                            data-team="{{ $filters['team'] ?? '' }}"
                            onclick="toggleDropdown('dropdownTime')"
                        >
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
                                <a href="#" data-team="" data-count="{{ array_sum($availableTeamsCounts) }}">
                                    <span>Todos</span>
                                </a>
                                @foreach($teamOptions as $teamOption)
                                    @php
                                        $teamUrl = $teamOption['url'] ?? '';
                                        $teamCount = $teamUrl ? ($availableTeamsCounts[$teamUrl] ?? 0) : 0;
                                    @endphp
                                    @continue(!$teamUrl)
                                    <a href="#" data-team="{{ $teamUrl }}" data-count="{{ $teamCount }}">
                                        <span>{{ $teamOption['name'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="filter-group checkbox">
                        <h4>Gênero</h4>
                        @foreach($genderLabels as $value => $label)
                            @php
                                $count = $availableGenderCounts[$value] ?? 0;
                                $isSelected = in_array($value, $selectedGender, true);
                            @endphp
                            @if($count > 0 || $isSelected)
                                <label data-count="{{ $count }}">
                                    <input
                                        type="checkbox"
                                        name="gender[]"
                                        value="{{ $value }}"
                                        data-filter-group="gender"
                                        data-filter-value="{{ $value }}"
                                        data-filter-origin="desktop"
                                        {{ $isSelected ? 'checked' : '' }}
                                    />
                                    <span class="custom-checkbox"></span>
                                    <span class="label-text">{{ $label }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <!-- Filtro por Tamanho -->
                    <div class="filter-group checkbox">
                        <h4>Tamanho</h4>
                        @foreach($sizeLabels as $value => $label)
                            @php
                                $count = $availableSizeCounts[$value] ?? 0;
                                $isSelected = in_array($value, $selectedSizes, true);
                            @endphp
                            @if($count > 0 || $isSelected)
                                <label data-count="{{ $count }}">
                                    <input
                                        type="checkbox"
                                        name="size[]"
                                        value="{{ $value }}"
                                        data-filter-group="size"
                                        data-filter-value="{{ $value }}"
                                        data-filter-origin="desktop"
                                        {{ $isSelected ? 'checked' : '' }}
                                    />
                                    <span class="custom-checkbox"></span>
                                    <span class="label-text">{{ $label }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <!-- Temporada -->
                    <div class="filter-group">
                        <h4>Temporada</h4>
                        <div
                            class="sort-select"
                            id="sortSelectTemporada"
                            data-season="{{ $filters['season'] ?? '' }}"
                            onclick="toggleDropdown('dropdownTemporada')"
                        >
                            {{ $filters['season'] ?? 'Todos' }}
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTemporada">
                                <a href="#" data-season="" data-count="{{ array_sum($availableSeasonCounts) }}">
                                    <span>Todos</span>
                                </a>
                                @foreach($seasonOptions as $season)
                                    @php
                                        $seasonCount = $availableSeasonCounts[$season] ?? 0;
                                    @endphp
                                    <a href="#" data-season="{{ $season }}" data-count="{{ $seasonCount }}">
                                        <span>{{ $season }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    @if(count($primaryCategoryKeys) > 0)
                        <div class="filter-group checkbox">
                            <h4>Categoria</h4>
                            @foreach($primaryCategoryKeys as $categoryKey)
                                @php
                                    $count = $availableCategoryCounts[$categoryKey] ?? 0;
                                    $isSelected = in_array($categoryKey, $selectedCategories, true);
                                    $label = $categoryLabels[$categoryKey] ?? $categoryKey;
                                @endphp
                                @if($count > 0 || $isSelected)
                                    <label data-count="{{ $count }}">
                                        <input
                                            type="checkbox"
                                            name="category[]"
                                            value="{{ $categoryKey }}"
                                            data-filter-group="category"
                                            data-filter-value="{{ $categoryKey }}"
                                            data-filter-origin="desktop"
                                            {{ $isSelected ? 'checked' : '' }}
                                        />
                                        <span class="custom-checkbox"></span>
                                        <span class="label-text">{{ $label }}</span>
                                    </label>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    <div class="filter-group checkbox">
                        <h4>Nacional / Internacional</h4>
                        @foreach($nationalityLabels as $value => $label)
                            @php
                                $count = $availableNationalCounts[$value] ?? 0;
                                $isSelected = in_array($value, $selectedNational, true);
                            @endphp
                            @if($count > 0 || $isSelected)
                                <label data-count="{{ $count }}">
                                    <input
                                        type="checkbox"
                                        name="national_international[]"
                                        value="{{ $value }}"
                                        data-filter-group="national_international"
                                        data-filter-value="{{ $value }}"
                                        data-filter-origin="desktop"
                                        {{ $isSelected ? 'checked' : '' }}
                                    />
                                    <span class="custom-checkbox"></span>
                                    <span class="label-text">{{ $label }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <div class="filter-group" style="display: none;">
                        <h4>Tipo de produto</h4>
                        <div
                            class="sort-select"
                            id="sortSelectTipo"
                            data-product-type="{{ $filters['product_type'] ?? '' }}"
                            onclick="toggleDropdown('dropdownTipo')"
                        >
                            {{ $productTypeLabels[$filters['product_type'] ?? ''] ?? 'Todos' }}
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTipo">
                                @foreach($productTypeLabels as $value => $label)
                                    @php
                                        $count = $value === '' ? array_sum($availableTypeCounts) : ($availableTypeCounts[$value] ?? 0);
                                        $isSelected = ($filters['product_type'] ?? '') === $value;
                                        $shouldShow = $value === '' || $count > 0 || $isSelected;
                                    @endphp
                                    @if($shouldShow)
                                        <a href="#" data-product-type="{{ $value }}" data-count="{{ $count }}">
                                            <span>{{ $label }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="filter-group checkbox" style="display: none;">
                        <h4>Tipo de Camisa</h4>
                        @foreach($shirtCategoryKeys as $categoryKey)
                            @php
                                $count = $availableCategoryCounts[$categoryKey] ?? 0;
                                $isSelected = in_array($categoryKey, $selectedCategories, true);
                                $label = $categoryLabels[$categoryKey] ?? ucfirst($categoryKey);
                            @endphp
                            @if($count > 0 || $isSelected)
                                <label data-count="{{ $count }}">
                                    <input
                                        type="checkbox"
                                        name="category[]"
                                        value="{{ $categoryKey }}"
                                        data-filter-group="category"
                                        data-filter-value="{{ $categoryKey }}"
                                        data-filter-origin="desktop"
                                        {{ $isSelected ? 'checked' : '' }}
                                    />
                                    <span class="custom-checkbox"></span>
                                    <span class="label-text">{{ $label }}</span>
                                </label>
                            @endif
                        @endforeach
                    </div>

                </div>

                <div class="productList">
                    @if(isset($products) && count($products) > 0)
                        <!-- Desktop product count (hidden on mobile) -->
                        <div class="desktop-product-count" style="margin-bottom: 20px; color: #666; font-size: 14px;">
                            {{ $total }} produto{{ $total > 1 ? 's' : '' }} encontrado{{ $total > 1 ? 's' : '' }}
                         
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
                                                @if($product['special_price'])
                                                    <span class="price">{{ $product['special_price'] }}</span>
                                                    <span class="old-price">{{ $product['price'] }}</span>
                                                @else
                                                    <span class="price">{{ $product['price'] }}</span>
                                                @endif
                                            </div>
                                            <div>{{ $product['installment_price'] }}</div>
                                            {{-- <div class="stars">★★★★★ (5)</div> --}}
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
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($lastPage > 1)
                            <div class="pagination">
                                @php
                                    $basePath = '/camisas';
                                @endphp
                                @if($currentPage > 1)
                                    @php
                                        $prevFilters = array_merge($filters, ['page' => $currentPage - 1]);
                                        $prevUrl = \App\Support\Util\SeoUrlHelper::filtersToUrl($prevFilters, $basePath);
                                    @endphp
                                    <a href="{{ $prevUrl }}" class="page-link">Anterior</a>
                                @endif
                                
                                @for($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
                                    @php
                                        $pageFilters = array_merge($filters, ['page' => $i]);
                                        $pageUrl = \App\Support\Util\SeoUrlHelper::filtersToUrl($pageFilters, $basePath);
                                    @endphp
                                    <a href="{{ $pageUrl }}" 
                                       class="page-link {{ $i == $currentPage ? 'active' : '' }}">{{ $i }}</a>
                                @endfor
                                
                                @if($currentPage < $lastPage)
                                    @php
                                        $nextFilters = array_merge($filters, ['page' => $currentPage + 1]);
                                        $nextUrl = \App\Support\Util\SeoUrlHelper::filtersToUrl($nextFilters, $basePath);
                                    @endphp
                                    <a href="{{ $nextUrl }}" class="page-link">Próxima</a>
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
            <div class="filter-group" style="display: none;">
                <h4>Preço</h4>
                <input
                    type="range"
                    min="50"
                    max="500"
                    value="{{ $filters['price_max'] ?? 500 }}"
                    data-default="500"
                    class="price-slider"
                    id="mobilePriceSlider"
                >
                <div class="price-range" id="mobilePriceRange">R$ 50 - R$ {{ $filters['price_max'] ?? 500 }}</div>
            </div>

            <!-- Ordenar por -->
            <div class="filter-group">
                <h4>Ordenar por</h4>
                <div
                    class="sort-select"
                    id="mobileSortSelectOrdenar"
                    data-sort="{{ $filters['sort'] ?? 'most_sold' }}"
                    onclick="toggleDropdown('mobileDropdownMenu')"
                >
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
                <div
                    class="sort-select"
                    id="mobileSortSelectTime"
                    data-team="{{ $filters['team'] ?? '' }}"
                    onclick="toggleDropdown('mobileDropdownTime')"
                >
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
                        <a href="#" data-team="" data-count="{{ array_sum($availableTeamsCounts) }}">
                            <span>Todos</span>
                        </a>
                        @foreach($teamOptions as $teamOption)
                            @php
                                $teamUrl = $teamOption['url'] ?? '';
                                $teamCount = $teamUrl ? ($availableTeamsCounts[$teamUrl] ?? 0) : 0;
                            @endphp
                            @continue(!$teamUrl)
                            <a href="#" data-team="{{ $teamUrl }}" data-count="{{ $teamCount }}">
                                <span>{{ $teamOption['name'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="filter-group checkbox">
                <h4>Gênero</h4>
                @foreach($genderLabels as $value => $label)
                    @php
                        $count = $availableGenderCounts[$value] ?? 0;
                        $isSelected = in_array($value, $selectedGender, true);
                    @endphp
                    @if($count > 0 || $isSelected)
                        <label data-count="{{ $count }}">
                            <input
                                type="checkbox"
                                name="gender[]"
                                value="{{ $value }}"
                                data-filter-group="gender"
                                data-filter-value="{{ $value }}"
                                data-filter-origin="mobile"
                                {{ $isSelected ? 'checked' : '' }}
                            />
                            <span class="custom-checkbox"></span>
                            <span class="label-text">{{ $label }}</span>
                        </label>
                    @endif
                @endforeach
            </div>

            <!-- Filtro por Tamanho -->
            <div class="filter-group checkbox">
                <h4>Tamanho</h4>
                @foreach($sizeLabels as $value => $label)
                    @php
                        $count = $availableSizeCounts[$value] ?? 0;
                        $isSelected = in_array($value, $selectedSizes, true);
                    @endphp
                    @if($count > 0 || $isSelected)
                        <label data-count="{{ $count }}">
                            <input
                                type="checkbox"
                                name="size[]"
                                value="{{ $value }}"
                                data-filter-group="size"
                                data-filter-value="{{ $value }}"
                                data-filter-origin="mobile"
                                {{ $isSelected ? 'checked' : '' }}
                            />
                            <span class="custom-checkbox"></span>
                            <span class="label-text">{{ $label }}</span>
                        </label>
                    @endif
                @endforeach
            </div>

            <!-- Temporada -->
            <div class="filter-group">
                <h4>Temporada</h4>
                <div
                    class="sort-select"
                    id="mobileSortSelectTemporada"
                    data-season="{{ $filters['season'] ?? '' }}"
                    onclick="toggleDropdown('mobileDropdownTemporada')"
                >
                    {{ $filters['season'] ?? 'Todos' }}
                    <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                        <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                    </svg>
                </div>
                <div class="dropdown">
                    <div class="dropdown-content" id="mobileDropdownTemporada">
                        <a href="#" data-season="" data-count="{{ array_sum($availableSeasonCounts) }}">
                            <span>Todos</span>
                        </a>
                        @foreach($seasonOptions as $season)
                            @php
                                $seasonCount = $availableSeasonCounts[$season] ?? 0;
                            @endphp
                            <a href="#" data-season="{{ $season }}" data-count="{{ $seasonCount }}">
                                <span>{{ $season }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            @if(count($primaryCategoryKeys) > 0)
                <div class="filter-group checkbox">
                    <h4>Categoria</h4>
                    @foreach($primaryCategoryKeys as $categoryKey)
                        @php
                            $count = $availableCategoryCounts[$categoryKey] ?? 0;
                            $isSelected = in_array($categoryKey, $selectedCategories, true);
                            $label = $categoryLabels[$categoryKey] ?? $categoryKey;
                        @endphp
                        @if($count > 0 || $isSelected)
                            <label data-count="{{ $count }}">
                                <input
                                    type="checkbox"
                                    name="category[]"
                                    value="{{ $categoryKey }}"
                                    data-filter-group="category"
                                    data-filter-value="{{ $categoryKey }}"
                                    data-filter-origin="mobile"
                                    {{ $isSelected ? 'checked' : '' }}
                                />
                                <span class="custom-checkbox"></span>
                                <span class="label-text">{{ $label }}</span>
                            </label>
                        @endif
                    @endforeach
                </div>
            @endif
            <div class="filter-group checkbox">
                <h4>Nacional / Internacional</h4>
                @foreach($nationalityLabels as $value => $label)
                    @php
                        $count = $availableNationalCounts[$value] ?? 0;
                        $isSelected = in_array($value, $selectedNational, true);
                    @endphp
                    @if($count > 0 || $isSelected)
                        <label data-count="{{ $count }}">
                            <input
                                type="checkbox"
                                name="national_international[]"
                                value="{{ $value }}"
                                data-filter-group="national_international"
                                data-filter-value="{{ $value }}"
                                data-filter-origin="mobile"
                                {{ $isSelected ? 'checked' : '' }}
                            />
                            <span class="custom-checkbox"></span>
                            <span class="label-text">{{ $label }}</span>
                        </label>
                    @endif
                @endforeach
            </div>

            <div class="filter-group" style="display: none;">
                <h4>Tipo de produto</h4>
                <div
                    class="sort-select"
                    id="mobileSortSelectTipo"
                    data-product-type="{{ $filters['product_type'] ?? '' }}"
                    onclick="toggleDropdown('mobileDropdownTipo')"
                >
                    {{ $productTypeLabels[$filters['product_type'] ?? ''] ?? 'Todos' }}
                    <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                        <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                    </svg>
                </div>
                <div class="dropdown">
                    <div class="dropdown-content" id="mobileDropdownTipo">
                        @foreach($productTypeLabels as $value => $label)
                            @php
                                $count = $value === '' ? array_sum($availableTypeCounts) : ($availableTypeCounts[$value] ?? 0);
                                $isSelected = ($filters['product_type'] ?? '') === $value;
                                $shouldShow = $value === '' || $count > 0 || $isSelected;
                            @endphp
                            @if($shouldShow)
                                <a href="#" data-product-type="{{ $value }}" data-count="{{ $count }}">
                                    <span>{{ $label }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="filter-group checkbox" style="display: none;">
                <h4>Tipo de Camisa</h4>
                @foreach($shirtCategoryKeys as $categoryKey)
                    @php
                        $count = $availableCategoryCounts[$categoryKey] ?? 0;
                        $isSelected = in_array($categoryKey, $selectedCategories, true);
                        $label = $categoryLabels[$categoryKey] ?? ucfirst($categoryKey);
                    @endphp
                    @if($count > 0 || $isSelected)
                        <label data-count="{{ $count }}">
                            <input
                                type="checkbox"
                                name="category[]"
                                value="{{ $categoryKey }}"
                                data-filter-group="category"
                                data-filter-value="{{ $categoryKey }}"
                                data-filter-origin="mobile"
                                {{ $isSelected ? 'checked' : '' }}
                            />
                            <span class="custom-checkbox"></span>
                            <span class="label-text">{{ $label }}</span>
                        </label>
                    @endif
                @endforeach
            </div>
        </div>
        
        <div class="mobile-filter-actions">
            <button class="btn btn-clear" id="mobileClearFilters">Limpar</button>
            <button class="btn btn-apply" id="mobileApplyFilters">Aplicar</button>
        </div>
    </div>
    
    
    <script src="{!! asset('assets/js/list.min.js') !!}"></script>
@endsection
