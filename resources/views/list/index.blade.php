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
            <h1>Camisetas</h1>
            <div class="groupList">
                <div class="filter">
                    <h3>Filtrar por</h3>
                    <!-- Filtro por Preço -->
                    <div class="filter-group">
                        <h4>Preço</h4>
                        <input type="range" min="50" max="500" value="250" class="price-slider">
                        <div class="price-range">R$ 50 - R$ 500</div>
                    </div>

                    <!-- Filtro por Time -->
                    <div class="filter-group">
                        <h4>Time</h4>
                        <select>
                            <option value="">Selecione um time</option>
                            <option value="flamengo">Flamengo</option>
                            <option value="corinthians">Corinthians</option>
                            <option value="palmeiras">Palmeiras</option>
                            <option value="sao_paulo">São Paulo</option>
                            <option value="cruzeiro">Cruzeiro</option>
                        </select>
                    </div>

                    <!-- Filtro por Tamanho -->
                    <div class="filter-group">
                        <h4>Tamanho</h4>
                        <label><input type="checkbox"> P</label>
                        <label><input type="checkbox"> M</label>
                        <label><input type="checkbox"> G</label>
                        <label><input type="checkbox"> GG</label>
                    </div>

                    <!-- Filtro por Tipo -->
                    <div class="filter-group">
                        <h4>Tipo</h4>
                        <label><input type="radio" name="tipo"> Torcedor</label>
                        <label><input type="radio" name="tipo"> Jogador</label>
                        <label><input type="radio" name="tipo"> Treino</label>
                    </div>

                    <!-- Ordenação -->
                    <div class="filter-group">
                        <h4>Ordenar por</h4>
                        <select class="sort-select">
                            <option>Mais vendidos</option>
                            <option>Menor preço</option>
                            <option>Maior desconto</option>
                        </select>
                    </div>
                </div>

                <div class="productList">
                    <div class="grid">
                        <div class="card">
                            <div class="cardContent">
                                <span class="badge">5%</span>
                                <img
                                    src="https://promantos.com.br/cdn/shop/files/comprar-camisa-camiseta-blusa-do-sao-paulo-nova-lancamento-new-balance-da-temporada-2024_25-24_25-iii-3-terceira-third-vermelha-com-preto-torcida-que-conduz-onibus-masculina-versao-mo_14b6de24-e00c-48bb-bb0c-7879521434a8_700x.jpg?v=1730630374"
                                    alt="Camisa Torcedor Corinthians Treino">
                            </div>
                            <div class="info">
                                <h3>Camisa Torcedor Corinthians Treino 2025/26 - Masculina</h3>
                                <div>
                                    <span class="price">R$ 179,90</span>
                                    <span class="old-price">R$ 190,00</span>
                                </div>
                                <div>em até 12x de R$ 18,55</div>
                                <div class="stars">★★★★★ (5)</div>
                                <span class="free-shipping">FRETE GRÁTIS</span>
                            </div>
                        </div>

                        <!-- Card 2 -->
                        <div class="card">
                            <div class="cardContent">
                                <span class="badge">25%</span>
                                <img
                                    src="https://promantos.com.br/cdn/shop/files/comprar-camisa-camiseta-blusa-do-cruzeiro-nova-lancamento-adidas-da-temporada-2024_25-24_25-i-1-titular-principal-primeira-home-azul-estrelas-masculina-versao-modelo-torcedor-tailande_85247cca-c0ca-49f3-9af3-c303c22b5126_700x.jpg?v=1730852684"
                                    alt="Camisa Jogador Corinthians II">
                            </div>
                            <div class="info">
                                <h3>Camisa Jogador Corinthians II 2024/25</h3>
                                <div>
                                    <span class="price">R$ 239,90</span>
                                    <span class="old-price">R$ 320,00</span>
                                </div>
                                <div>em até 12x de R$ 24,74</div>
                                <div class="stars">★★★★★ (5)</div>
                                <span class="free-shipping">FRETE GRÁTIS</span>
                            </div>
                        </div>

                        <!-- Card 3 -->
                        <div class="card">
                            <div class="cardContent">
                                <span class="badge">5%</span>
                                <img
                                    src=https://promantos.com.br/cdn/shop/files/camisa-camiseta-blusa-do-botafogo-fogao-reebook-nova-lancamento-da-temporada-ano-2024_25-24_25-i-1-titular-principal-primeira-home-listrada-alvinegra-preta-e-branco-masculina-versao-m_544fe31a-d863-470a-91ed-3d06b62b6b3b_700x.jpg?v=1719517896"
                                    alt="Camisa Torcedor Botafogo I">
                            </div>
                            <div class="info">
                                <h3>Camisa Torcedor Botafogo I 2024/25 - Masculina</h3>
                                <div>
                                    <span class="price">R$ 179,90</span>
                                    <span class="old-price">R$ 190,00</span>
                                </div>
                                <div>em até 12x de R$ 18,55</div>
                                <div class="stars">★★★★★ (5)</div>
                                <span class="free-shipping">FRETE GRÁTIS</span>
                            </div>
                        </div>

                        <!-- Card 4 -->
                        <div class="card">
                            <div class="cardContent">
                                <span class="badge">5%</span>
                                <img
                                    src="https://promantos.com.br/cdn/shop/files/camisa-camiseta-blusa-do-cruzeiro-nova-lancamento-adidas-da-temporada-2025_26-25_26-de-treino-treinamento-adidas-raposa-verde-azul-masculina-versao-modelo-torcedor-tailandesa-replica_7b13c365-d3d1-4cbb-988d-00220076eb5e_700x.jpg?v=1736891803"
                                    alt="Camisa Torcedor Cruzeiro Treino">
                            </div>
                            <div class="info">
                                <h3>Camisa Torcedor Cruzeiro Treino 2025/26 - Masculina</h3>
                                <div>
                                    <span class="price">R$ 179,90</span>
                                    <span class="old-price">R$ 190,00</span>
                                </div>
                                <div>em até 12x de R$ 18,55</div>
                                <div class="stars">★★★★★ (5)</div>
                                <span class="free-shipping">FRETE GRÁTIS</span>
                            </div>
                        </div>

                        <div class="card">
                            <div class="cardContent">
                                <span class="badge">5%</span>
                                <img
                                    src=https://promantos.com.br/cdn/shop/files/camisa-camiseta-blusa-do-botafogo-fogao-reebook-nova-lancamento-da-temporada-ano-2024_25-24_25-i-1-titular-principal-primeira-home-listrada-alvinegra-preta-e-branco-masculina-versao-m_544fe31a-d863-470a-91ed-3d06b62b6b3b_700x.jpg?v=1719517896"
                                    alt="Camisa Torcedor Botafogo I">
                            </div>
                            <div class="info">
                                <h3>Camisa Torcedor Botafogo I 2024/25 - Masculina</h3>
                                <div>
                                    <span class="price">R$ 179,90</span>
                                    <span class="old-price">R$ 190,00</span>
                                </div>
                                <div>em até 12x de R$ 18,55</div>
                                <div class="stars">★★★★★ (5)</div>
                                <span class="free-shipping">FRETE GRÁTIS</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
