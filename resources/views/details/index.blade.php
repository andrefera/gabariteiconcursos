@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/detail.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/plugins.css') !!}">

<style>
    /* Zoom lens styles - scoped to product detail page */
    .imageMain { position: relative; }
    .zoomLens {
        position: absolute;
        display: none;
        width: 180px;
        height: 180px;
        border: 2px solid #ffffff;
        border-radius: 50%;
        box-shadow: 0 6px 24px rgba(0,0,0,0.18), 0 0 0 2px rgba(0,0,0,0.06);
        background-repeat: no-repeat;
        pointer-events: none;
        z-index: 5;
        transition: opacity .15s ease, transform .15s ease;
        opacity: 0;
        transform: scale(.92);
        overflow: hidden;
    }
</style>

@section('content')
    <div class="alignSection">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="#">Início</a></li>
                <li><a href="/camisas">Camisetas</a></li>
                <li class="active">{{$product->name}}</li>
            </ol>
        </nav>
    </div>
    <section class="detailSection fade-in">
        <div class="alignSection">
            <div class="productArea">
                <div class="imageArea">
                    <!-- Container da imagem principal -->
                    @if(isset($product->images[0]))
                        <div class="imageMain">
                            <img width="600" height="600"
                                 src="{{ $product->images[0]->url }}"
                                 alt="{{ $product->name }}"
                                 class="main-product-image"
                                 id="mainImage">
                            <div class="zoomLens" id="zoomLens"></div>
                        </div>
                    @endif

                    <!-- Miniaturas das imagens -->
                    @if(!empty($product->images) && count($product->images) > 1)
                        <div class="otherImages">
                            @foreach($product->images as $index => $image)
                                <div class="otherImage {{ $index === 0 ? 'active' : '' }}" data-index="{{$index}}">
                                    <img src="{{ $image->url }}" alt="{{ $product->name }} - {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    {{-- <div class="mobileStars">
                        <div class="stars">★★★★★
                            <p>(121)</p>
                        </div>
                    </div> --}}
                </div>

                <div class="textArea">
                    <div class="firstStep">
                        <h1 class="title">{{$product->name}}</h1>
                        <div class="stars">★★★★★
                            <p>(121)</p>
                        </div>
                    </div>
                    <div class="secondStep">
                        <div class="priceGroup">
                            @if($product->special_price && $product->discount_percentage)
                                <div class="discountArea">
                                    <span class="totalPrice">de {{$product->price}}</span>
                                    <span class="offer">{{$product->discount_percentage}} OFF</span>
                                </div>
                            @endif
                            <div class="group">
                                <div class="alignPrice">
                                    <p class="price">{{$product->installment_price}}</p>
                                    <span
                                        class="specialPrice">ou {{$product->special_price ?? $product->price}} à vista</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($product->sizes))
                        <div class="thirdStep">
                            <p class="choose">Escolha sua medida</p>
                            <div class="buttons">
                                @foreach($product->sizes as $key => $size)
                                    <button class="btnMeasure">{{$size->name}}</button>
                                @endforeach
                            </div>
{{--                            <button class="tableMeasure">--}}
{{--                                <img width="22" height="22" src="{{ asset('images/icons/regua-icon.png') }}" alt="regua">--}}
{{--                                <p> Tabela de Medidas</p>--}}
{{--                            </button>--}}
                        </div>
                        <div class="fourthStep">
                            <div class="quantityArea">
                                <div class="quantityGroup">
                                    <button class="btnQtd"><p class="less">-</p></button>
                                    <p class="quantity">1</p>
                                    <button class="btnQtd">+</button>
                                </div>
                                <div class="phrase">
                                    <p>Restam apenas <span>12 itens</span></p>
                                    <p>Não perca essa!</p>
                                </div>
                            </div>
                            <div class="buyArea">
                                <button class="btnBuy">Comprar Agora</button>
                                <button class="btnCart">Adicionar ao Carrinho</button>
                            </div>
                        </div>
                    @else
                        <div class="thirdStep">
                            <div class="out-of-stock-message" style="padding: 20px; text-align: center; background-color: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; margin-top: 20px;">
                                <p style="font-size: 18px; font-weight: bold; color: #dc2626; margin: 0;">Produto Fora de Estoque</p>
                                <p style="font-size: 14px; color: #991b1b; margin-top: 8px;">Desculpe, este produto está temporariamente indisponível.</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="descriptionSection">
        <div class="alignSection">
            <hr>
            @if($product->description)
                <p class="title">Descrição</p>
                <p class="description">{{$product->description}}</p>
            @endif

            <div class="informations">
                <div class="groupInfo">
                    <p><span>Nome:</span> {{$product->name}}</p>
                    <p><span>Gênero:</span> {{$product->gender}}</p>
                    <p><span>Indicado para:</span> Jogo</p>
                    @if($product->team)
                        <p><span>Time:</span> {{$product->team}}</p>
                    @endif

                </div>
                <div class="groupInfo">
                    <p><span>Gola:</span> Gola V</p>
                    <p><span>Material:</span> Poliéster</p>
                    <p><span>Manga:</span> Manga Curta</p>
                    <p><span>Escudo:</span> Patch</p>
                    <p><span>Patrocínio:</span> Com patrocínio</p>
                    <p><span>Número:</span> Sem número</p>
                </div>
                <div class="groupInfo">
                    <p>
                    <p><span>Composição:</span> 100% Poliéster</p>
                    <p><span>Garantia do Fabricante:</span> Contra defeito de fabricação</p>
                    <p><span>Origem:</span> Nacional</p>
                    <p><span>Marca:</span> Umbro</p>
                </div>
            </div>
        </div>
    </section>
    <section class="reviewSection">
        <div class="alignSection">
            <hr>
            <p class="title">Avaliações dos Clientes</p>
            <div class="reviewGroup">
                <div class="review-summary">
                    <div class="review-score">
                        <span class="score">4.7</span>
                        <div class="stars">
                            ★★★★★<span class="half-star">★</span>
                        </div>
                        <p class="total-reviews">78 avaliações</p>
                    </div>
                    <div class="review-bars">
                        <div class="review-bar">
                            <span class="stars-label">5 ★</span>
                            <div class="bar">
                                <div class="filled" style="width: 80%;"></div>
                            </div>
                        </div>
                        <div class="review-bar">
                            <span class="stars-label">4 ★</span>
                            <div class="bar">
                                <div class="filled" style="width: 15%;"></div>
                            </div>
                        </div>
                        <div class="review-bar">
                            <span class="stars-label">3 ★</span>
                            <div class="bar">
                                <div class="filled" style="width: 3%;"></div>
                            </div>
                        </div>
                        <div class="review-bar">
                            <span class="stars-label">2 ★</span>
                            <div class="bar">
                                <div class="filled" style="width: 1%;"></div>
                            </div>
                        </div>
                        <div class="review-bar">
                            <span class="stars-label">1 ★</span>
                            <div class="bar">
                                <div class="filled" style="width: 1%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="reviews">
                    <div class="review">
                        <p class="reviewName">Pedro Sergio | <span class="reviewDate">10 de Março</span></p>
                        <p class="reviewStars">★★★★★</p>
                        <p class="reviewText">"A qualidade do tecido é incrível! Confortável, respirável e com uma
                            estampa
                            que não desbota. Vale cada centavo! A qualidade do tecido é incrível! Confortável,
                            respirável e
                            com uma estampa
                            que não desbota. Vale cada centavo! A qualidade do tecido é incrível! Confortável,
                            respirável e
                            com uma estampa
                            que não desbota. Vale cada centavo!"</p>
                    </div>
                    <div class="review">
                        <p class="reviewName">Pedro Sergio | <span class="reviewDate">10 de Março</span></p>
                        <p class="reviewStars">★★★★</p>
                        <p class="reviewText">"A modelagem ficou perfeita e o tecido é muito bom. Só demorou um pouco
                            para
                            chegar, mas a espera valeu a pena."</p>
                        <div class="photoGroup">
                            <img alt="" width="150" height="200"
                                 src="https://http2.mlstatic.com/D_NQ_NP_2X_928641-MLA75619515009_042024-F.webp">
                            <img alt="" width="150" height="200"
                                 src="https://http2.mlstatic.com/D_NQ_NP_2X_847820-MLA82768018972_032025-O.webp">
                        </div>
                    </div>
                    <div class="review">
                        <p class="reviewName">Pedro Sergio | <span class="reviewDate">10 de Março</span></p>
                        <p class="reviewStars">★★★★★</p>
                        <p class="reviewText">"Surpreendido positivamente! Material resistente, cores vivas e o caimento
                            no
                            corpo ficou excelente. Recomendo demais!"</p>
                    </div>
                    <div class="review">
                        <p class="reviewName">Pedro Sergio | <span class="reviewDate">10 de Março</span></p>
                        <p class="reviewStars">★★★</p>
                        <p class="reviewText">"A camisa é elogiada por seu design atraente e qualidade, sendo
                            considerada
                            uma ótima compra. O ajuste é adequado para crianças, com tamanhos que correspondem bem às
                            expectativas. Além disso, a satisfação com o produto é destacada, especialmente entre os
                            jovens
                            torcedores."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="productSection">
        <div class="alignSection">
            <hr>
            <p class="title">Produtos Relacionados</p>
            <div class="grid">
                <!-- Card 1 -->
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
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="linkSection">
        <div class="alignSection">
            <hr>
            <p class="title">Outras páginas acessadas</p>
            <div class="outherLinks">
                <ul class="mostWantesLinks">
                    <li><a href="/suplementos/creatina">
                            creatina
                        </a></li>
                    <li><a href="/busca/sapatos-masculinos">
                            sapatos masculinos
                        </a></li>
                    <li><a href="/relogios/masculino">
                            relógios masculinos
                        </a></li>
                    <li><a href="/tenis/tesla">
                            tesla tenis
                        </a></li>
                    <li><a href="/busca/papete-feminina">
                            papete feminina
                        </a></li>
                    <li><a href="/busca/creatina-integralmedica">
                            creatina integralmedica
                        </a></li>
                    <li><a href="/busca/creatina-monohidratada">
                            creatina monohidratada
                        </a></li>
                    <li><a href="/busca/creatina-creapure">
                            creatina creapure
                        </a></li>
                    <li><a href="/busca/whey-protein-com-creatina">
                            kit whey e creatina
                        </a></li>
                    <li><a href="/busca/creatina-1kg">
                            creatina 1kg
                        </a></li>
                    <li><a href="/camisa/masculino">
                            camiseta masculina
                        </a></li>
                    <li><a href="/mochilas/masculino">
                            mochila masculina
                        </a></li>
                    <li><a href="/busca/creatina-universal">
                            creatina universal
                        </a></li>
                    <li><a href="/busca/tenis-pra-crossfit">
                            tenis crossfit
                        </a></li>
                    <li><a href="/busca/papete-feminina-beira-rio">
                            papete beira rio
                        </a></li>
                    <li><a href="/growth-supplements">
                            growth supplements
                        </a></li>
                    <li><a href="/busca/creatina-growth">
                            creatina groth
                        </a></li>
                    <li><a href="/busca/chuteira-society-nike">
                            chuteira society nike
                        </a></li>
                    <li><a href="/busca/camisa-do-sao-paulo">
                            camisa do sao paulo
                        </a></li>
                    <li><a href="/busca/chinelo-nike">
                            chinelo nike
                        </a></li>
                    <li><a href="/busca/creatina-probiotica-300g">
                            creatina probiotica
                        </a></li>
                    <li><a href="/suplementos/creatina/black-skull">
                            creatina black skull
                        </a></li>
                    <li><a href="/sandalias/feminino">
                            sandalias femininas
                        </a></li>
                    <li><a href="/sapato-social/masculino">
                            sapato social masculino
                        </a></li>
                    <li><a href="/busca/tenis-nike-court-vision">
                            nike court vision
                        </a></li>
                    <li><a href="/volei/bolas">
                            bola de volei
                        </a></li>
                    <li><a href="/tenis/feminino/adidas">
                            tenis adidas feminino
                        </a></li>
                    <li><a href="/busca/creatina-masterway">
                            creatina masterway
                        </a></li>
                    <li><a href="/busca/calca-cargo-masculina">
                            calça cargo masculina
                        </a></li>
                    <li><a href="/oculos/masculino">
                            oculos de sol
                        </a></li>
                    <li><a href="/busca/whey-growth">
                            whey growth
                        </a></li>
                    <li><a href="/busca/whey-protein-isolado">
                            whey protein isolado
                        </a></li>
                    <li><a href="/busca/calca-sarja">
                            calça sarja
                        </a></li>
                    <li><a href="/futebol/luvas-de-goleiro">
                            luva de goleiro profissional
                        </a></li>
                    <li><a href="/suplementos/creatina/max-titanium">
                            creatina max titanium 300g
                        </a></li>
                </ul>
            </div>
        </div>
    </section>
@endsection

<!-- Scripts -->
<script src="{{ asset('assets/js/plugins.min.js') }}?v={{ env('STATIC_VERSION', time()) }}"></script>
<script src="{{ asset('assets/js/detail.min.js') }}?v={{ env('STATIC_VERSION', time()) }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Fade-in já existente
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach(element => {
            element.classList.add('show');
        });

        // Troca de imagem principal ao clicar nas miniaturas
        const mainImageEl = document.getElementById('mainImage');
        const zoomLensEl = document.getElementById('zoomLens');
        const thumbnailContainers = document.querySelectorAll('.otherImage');
        if (mainImageEl && thumbnailContainers.length) {
            thumbnailContainers.forEach(container => {
                container.addEventListener('click', function () {
                    // remove estado ativo anterior
                    thumbnailContainers.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    const img = this.querySelector('img');
                    if (img) {
                        mainImageEl.src = img.getAttribute('src');
                        const altText = img.getAttribute('alt');
                        if (altText) {
                            mainImageEl.alt = altText;
                        }
                        // atualizar imagem de fundo do zoom quando a principal muda
                        if (zoomLensEl) {
                            zoomLensEl.style.backgroundImage = `url('${mainImageEl.src}')`;
                        }
                    }
                });
            });
        }

        // Seleção de tamanho
        let selectedSize = null;
        const btnMeasures = document.querySelectorAll('.btnMeasure');
        if (btnMeasures.length > 0) {
            btnMeasures.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.querySelectorAll('.btnMeasure').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    selectedSize = this.textContent.trim();
                });
            });
        }

        // Controle de quantidade
        let quantity = 1;
        const quantityDisplay = document.querySelector('.quantity');
        const btnsQtd = document.querySelectorAll('.btnQtd');
        if (quantityDisplay && btnsQtd.length >= 2) {
            btnsQtd[0].addEventListener('click', function () {
                if (quantity > 1) {
                    quantity--;
                    quantityDisplay.textContent = quantity;
                }
            });
            btnsQtd[1].addEventListener('click', function () {
                quantity++;
                quantityDisplay.textContent = quantity;
            });
        }

        async function addItemToCart(){
            const productId = "{{ $product->id }}";
            if (!selectedSize) {
                showToast('Atenção', 'Selecione um tamanho!', 'warning');
                return;
            }
            // CSRF token do Laravel
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            try {
                const response = await fetch("{{ route('cart.add') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        size: selectedSize,
                        quantity: quantity
                    })
                });
                if (response.ok) {
                    return { success: true, message: 'Produto adicionado ao carrinho!' };
                } else {
                    const data = await response.json();
                    return { success: false, message: data.message || 'Erro ao adicionar ao carrinho.' };
                }
            } catch (e) {
                return { success: false, message: 'Erro ao adicionar ao carrinho.' };
            }
        }

        // Adicionar ao Carrinho
        const btnBuy = document.querySelector('.btnBuy');
        const btnCart = document.querySelector('.btnCart');

        if (btnBuy) {
            btnBuy.addEventListener('click', async function () {
                const result = await addItemToCart();
                if (result.success) {
                    window.location.href = '/cart';
                } else {
                    showToast('Erro', result.message, 'error');
                }
            });
        }

        if (btnCart) {
            btnCart.addEventListener('click', async function () {
                const result = await addItemToCart();
                if (result.success) {
                    showToast('Sucesso', result.message, 'success');
                } else {
                    showToast('Erro', result.message, 'error');
                }
            });
        }

        // Efeito de zoom na imagem principal
        if (mainImageEl && zoomLensEl) {
            const imageMainContainer = mainImageEl.parentElement;
            const lens = zoomLensEl;
            const zoomScale = 2.2; // fator de zoom
            let scaleX = 1, scaleY = 1;

            const updateLensBackground = () => {
                lens.style.backgroundImage = `url('${mainImageEl.src}')`;
                const naturalWidth = mainImageEl.naturalWidth || mainImageEl.width;
                const naturalHeight = mainImageEl.naturalHeight || mainImageEl.height;
                const displayWidth = mainImageEl.clientWidth;
                const displayHeight = mainImageEl.clientHeight;
                // tamanho do background (zoom aplicado)
                const bgW = naturalWidth * zoomScale;
                const bgH = naturalHeight * zoomScale;
                lens.style.backgroundSize = `${bgW}px ${bgH}px`;
                // escala para converter coordenadas da tela para a imagem com zoom
                scaleX = (naturalWidth / displayWidth) * zoomScale;
                scaleY = (naturalHeight / displayHeight) * zoomScale;
            };
            updateLensBackground();

            const getCursorPos = (e) => {
                const rect = imageMainContainer.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                return { x, y, rect };
            };

            const moveLens = (e) => {
                const { x, y, rect } = getCursorPos(e);
                const lensW = lens.offsetWidth;
                const lensH = lens.offsetHeight;
                // centro da lente deve seguir o ponteiro
                let centerX = x;
                let centerY = y;
                // limitar para que a lente não ultrapasse as bordas
                const halfW = lensW / 2;
                const halfH = lensH / 2;
                if (centerX < halfW) centerX = halfW;
                if (centerX > rect.width - halfW) centerX = rect.width - halfW;
                if (centerY < halfH) centerY = halfH;
                if (centerY > rect.height - halfH) centerY = rect.height - halfH;

                lens.style.left = `${centerX - halfW}px`;
                lens.style.top = `${centerY - halfH}px`;

                // posiciona o background para que o ponto sob o cursor fique no centro da lente
                const bgX = centerX * scaleX - halfW;
                const bgY = centerY * scaleY - halfH;
                lens.style.backgroundPosition = `-${bgX}px -${bgY}px`;
            };

            imageMainContainer.addEventListener('mouseenter', () => {
                lens.style.display = 'block';
                // força recálculo para ativar a transição
                // eslint-disable-next-line no-unused-expressions
                lens.offsetHeight;
                lens.style.opacity = '1';
                lens.style.transform = 'scale(1)';
                updateLensBackground();
            });
            imageMainContainer.addEventListener('mousemove', moveLens);
            imageMainContainer.addEventListener('mouseleave', () => {
                lens.style.opacity = '0';
                lens.style.transform = 'scale(.92)';
                setTimeout(() => { lens.style.display = 'none'; }, 140);
            });
            window.addEventListener('resize', updateLensBackground);
            mainImageEl.addEventListener('load', updateLensBackground);
        }
    });
</script>
