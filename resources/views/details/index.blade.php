@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/detail.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/plugins.css') !!}">

@section('content')
    <div class="alignSection">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="#">Início</a></li>
                <li><a href="/camisetas">Camisetas</a></li>
                <li class="active">Camisa Jogador Flamengo | 2024/25</li>
            </ol>
        </nav>
    </div>
    <section class="detailSection fade-in">
        <div class="alignSection">
            <div class="productArea">
                <div class="imageArea">
                    <!-- Container da imagem principal -->
                    <div class="imageMain">
                        <img width="600" height="600"
                             src="https://promantos.com.br/cdn/shop/files/E0FFA9E0-E91B-40E8-95F9-4C95F7A592D7_600x.jpg?v=1731013907"
                             alt="Camisa Jogador Flamengo - Vista Frontal"
                             class="main-product-image"
                             id="mainImage">
                    </div>

                    <!-- Miniaturas das imagens -->
                    <div class="otherImages">
                        <div class="otherImage active" data-index="0">
                            <img src="https://promantos.com.br/cdn/shop/files/E0FFA9E0-E91B-40E8-95F9-4C95F7A592D7_600x.jpg?v=1731013907"
                                 alt="Camisa Jogador Flamengo - Vista Frontal">
                        </div>
                        <div class="otherImage" data-index="1">
                            <img src="https://promantos.com.br/cdn/shop/files/1F114692-6679-4C04-96AA-FFD3F50850E7_600x.png?v=1714416123"
                                 alt="Camisa Jogador Flamengo - Detalhes">
                        </div>
                        <div class="otherImage" data-index="2">
                            <img src="https://promantos.com.br/cdn/shop/files/1B615CE0-111C-429A-AC68-23E66C7D5FDE_600x.png?v=1714416123"
                                 alt="Camisa Jogador Flamengo - Costas">
                        </div>
                        <div class="otherImage" data-index="3">
                            <img src="https://promantos.com.br/cdn/shop/files/camisa-camiseta-blusa-do-flamengo-nova-lancamento-da-temporada-2024_25-24_25-i-1-titular-principal-primeira-home-vermelha-e-preta-rubro-negra-listrada-masculina-versao-modelo-jogador_f4115a4b-e150-4d98-9996-4e133afcb6ff_600x.jpg?v=1714416123"
                                 alt="Camisa Jogador Flamengo - Vista Completa">
                        </div>
                    </div>
                </div>

                <div class="textArea">
                    <div class="firstStep">
                        <h1 class="title">Camisa Jogador Flamengo | 2024/25 - Paixão Pelo Mengão</h1>
                        <div class="stars">★★★★★
                            <p>(121)</p>
                        </div>
                    </div>
                    <div class="secondStep">
                        <div class="priceGroup">
                            <div class="discountArea">
                                <span class="totalPrice">de R$ 525,60</span>
                                <span class="offer">43% OFF</span>
                            </div>
                            <div class="group">
                                <div class="alignPrice">
                                    <p class="price">12x de R$ 24,75</p>
                                    <span class="specialPrice">ou R$ 297,00 à vista</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="thirdStep">
                        <p class="choose">Escolha sua medida</p>
                        <div class="buttons">
                            <button class="active btnMeasure">P</button>
                            <button class="btnMeasure">M</button>
                            <button class="btnMeasure">G</button>
                            <button class="btnMeasure">GG</button>
                        </div>
                        <button class="tableMeasure">
                            <img width="22" height="22" src="{{ asset('images/icons/regua-icon.png') }}" alt="regua">
                            <p> Tabela de Medidas</p>
                        </button>
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
                </div>
            </div>
        </div>
    </section>

    <section class="descriptionSection">
        <div class="alignSection">
            <hr>
            <p class="title">Descrição</p>
            <p class="description">
                Essa armadura vai te cair bem, tricolor! Essa Camisa Fluminense II 24/25 s/n°Jogador Umbro Masculina é a
                escolha perfeita para demonstrar a paixão pelo Tricolor das Laranjeiras com estilo e conforto. Feita em
                poliéster, a peça é leve e respirável, ideal para curtir uma vitória no Maraca e para o dia a dia.
                Predominantemente branca, a camisa do Fluminense apresenta gola V e mangas curtas, dando um ar de
                modernidade a esta versão da camisa do Flu. As listras em verde e grená, presentes na parte frontal e
                nas costas, trazem as cores históricas do Fluminense, reforçando a identidade tricolor. Por fim, essa
                camisa de time conta com um pequeno patch com o tema “Paixão Carioca” - representando o mar, céu e
                areia, celebrando a cultura e beleza do Rio de Janeiro. Clube com mais história, sei que não há. Adquira
                já, tricolor!
            </p>
            <div class="informations">
                <div class="groupInfo">
                    <p><span>Nome:</span> Camisa Jogador Flamengo | 2024/25 - Paixão Pelo Mengão</p>
                    <p><span>Gênero:</span> Masculino</p>
                    <p><span>Indicado para:</span> Jogo</p>
                    <p><span>Clube:</span> Nacional</p>
                    <p><span>Time:</span> Fluminense RJ</p>
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
                    <li><a href="/camisetas/masculino">
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
    <footer>
        <div class="footer-container">
            <div class="footer-logo">Footer</div>

            <div class="footer-links">
                <a href="#">Home</a>
                <a href="#">Produtos</a>
                <a href="#">Contato</a>
                <a href="#">Sobre Nós</a>
            </div>

            <div class="footer-social">
                <a href="#">⚽</a>
                <a href="#">📷</a>
                <a href="#">🐦</a>
                <a href="#">📘</a>
            </div>
        </div>
    </footer>
@endsection

<!-- Scripts -->
<script src="{{ asset('assets/js/plugins.min.js') }}?v={{ env('STATIC_VERSION', time()) }}"></script>
<script src="{{ asset('assets/js/detail.min.js') }}?v={{ env('STATIC_VERSION', time()) }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach(element => {
            element.classList.add('show');
        });
    });
</script>
