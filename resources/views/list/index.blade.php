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

                    <!-- Ordenar por -->
                    <div class="filter-group">
                        <h4>Ordenar por</h4>
                        <div class="sort-select" id="sortSelectOrdenar" onclick="toggleDropdown('dropdownMenu')">
                            Mais vendidos
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownMenu">
                                <a href="#">Mais vendidos</a>
                                <a href="#">Novidades</a>
                                <a href="#">Promoções</a>
                                <a href="#">Preço: menor para maior</a>
                                <a href="#">Preço: maior para menor</a>
                            </div>
                        </div>
                    </div>


                    <div class="filter-group">
                        <h4>Time</h4>
                        <div class="sort-select" id="sortSelectTime" onclick="toggleDropdown('dropdownTime')">
                            Time
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTime">
                                <a href="#">Corinthians</a>
                                <a href="#">Cruzeiro</a>
                                <a href="#">Botafogo</a>
                                <a href="#">São Paulo</a>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group checkbox">
                        <h4>Gênero</h4>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Masculino
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Feminino
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Infantil
                        </label>
                    </div>

                    <!-- Filtro por Tamanho -->
                    <div class="filter-group checkbox">
                        <h4>Tamanho</h4>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            P
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            M
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            G
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            GG
                        </label>
                    </div>

                    <!-- Temporada -->
                    <div class="filter-group">
                        <h4>Temporada</h4>
                        <div class="sort-select" id="sortSelectTemporada" onclick="toggleDropdown('dropdownTemporada')">
                            2023/24
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTemporada">
                                <a href="#">2023/24</a>
                                <a href="#">2024/25</a>
                                <a href="#">2025/26</a>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group checkbox">
                        <h4>Categoria</h4>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Retro
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Seleção
                        </label>
                    </div>

                    <div class="filter-group checkbox">
                        <h4>Nacional / Internacional</h4>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Nacional
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Internacional
                        </label>
                    </div>

                    <div class="filter-group">
                        <h4>Tipo de produto</h4>
                        <div class="sort-select" id="sortSelectTipo" onclick="toggleDropdown('dropdownTipo')">
                            Uniforme
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                                <path fill="#ff6600" d="M7 10l5 5 5-5z"/>
                            </svg>
                        </div>
                        <div class="dropdown">
                            <div class="dropdown-content" id="dropdownTipo">
                                <a href="#">Uniforme</a>
                                <a href="#">Casual</a>
                                <a href="#">Acessórios</a>
                            </div>
                        </div>
                    </div>

                    <div class="filter-group checkbox">
                        <h4>Nacional / Internacional</h4>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Torcedor
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Jogador
                        </label>
                        <label>
                            <input type="checkbox" />
                            <span class="custom-checkbox"></span>
                            Treino
                        </label>
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
                                    src="https://promantos.com.br/cdn/shop/files/comprarcamisacamisetablusanovalancamentodocruzeirodatemporada2025_2625_26i1titularprincipalprimeirahomeazulbetfairmasculinaversaotorcedortailandesareplicapromantosdudugabigolkaiojorge_700x.png?v=1743769427"
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
                                    src="https://promantos.com.br/cdn/shop/files/B0A54BED-544F-4E76-A75B-15CF1D62D691_700x.jpg?v=1744552590"
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
                                    src=https://promantos.com.br/cdn/shop/files/IMG_1331_700x.jpg?v=1746238379"
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
    <script>
        function toggleDropdown(id) {
            const dropdown = document.getElementById(id);
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        }

        document.addEventListener("click", function (event) {
            const allDropdowns = ["dropdownMenu", "dropdownTemporada"];
            const allButtons = ["sortSelectOrdenar", "sortSelectTemporada"];

            allDropdowns.forEach((id, index) => {
                const dropdown = document.getElementById(id);
                const button = document.getElementById(allButtons[index]);

                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.style.display = "none";
                }
            });
        });

        // Adiciona listeners para ambas dropdowns
        function setupDropdown(dropdownId, buttonId) {
            const links = document.querySelectorAll(`#${dropdownId} a`);
            links.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const selectedText = this.textContent;
                    const button = document.getElementById(buttonId);
                    button.childNodes[0].nodeValue = selectedText + " ";
                    document.getElementById(dropdownId).style.display = "none";
                });
            });
        }

        setupDropdown("dropdownMenu", "sortSelectOrdenar");
        setupDropdown("dropdownTemporada", "sortSelectTemporada");
        setupDropdown("dropdownTime", "sortSelectTime");
        setupDropdown("dropdownTipo", "sortSelectTipo");

        document.addEventListener("DOMContentLoaded", function () {
            const slider = document.querySelector(".price-slider");

            function updateSliderTrack() {
                const min = parseInt(slider.min);
                const max = parseInt(slider.max);
                const value = parseInt(slider.value);

                const percentage = ((value - min) / (max - min)) * 100;

                slider.style.background = `linear-gradient(to right, #ff6600 ${percentage}%, #ddd ${percentage}%)`;
            }

            slider.addEventListener("input", updateSliderTrack);

            // Atualizar ao carregar a página
            updateSliderTrack();
        });
    </script>
@endsection
