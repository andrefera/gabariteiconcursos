@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/home.css') !!}">
@section('content')
    <div class="banner">
        <img src="{{ asset('images/banner2.jpg') }}" alt="Ellon Sports Banner">
    </div>
    <section class="teamSection">
        <div class="alignSection">
            <h2 class="title">Navegue por times</h2>
            <div class="teamGroup">
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/botafogo.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/atletico.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/cruzeiro.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/corinthians.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/flamengo.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/palmeiras.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/vasco.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/saopaulo.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/fluminense.png') }}" alt="Ellon Sports Banner">
                </a>
            </div>
        </div>
    </section>

    <section class="destaques">
        <div class="alignSection">
            <h2 class="title">Destaques</h2>
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

    <section class="optionsProduct">
        <div class="alignSection">
            <div class="alignOptions">
                <a href="/" class="option">
                    <img src="{{ asset('images/banner-europeus.jpg') }}" alt="europa">
                </a>
                <a href="/" class="option">
                    <img src="{{ asset('images/banner-brasileiros.jpg') }}" alt="europa">
                </a>
                <a href="/" class="option">
                    <img src="{{ asset('images/banner-selecoes.jpg') }}" alt="europa">
                </a>
            </div>
        </div>
    </section>

    <section class="destaques">
        <div class="alignSection">
            <h2 class="title">Times Europeus</h2>
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

    <section class="promotions">
        <div class="alignSection">
            <div class="alignBanner">
                <img src="{{ asset('images/banner-down.jpg') }}" alt="Ellon Sports Banner">
            </div>
        </div>
    </section>

    <section class="safePurchase">
        <div class="alignSection">
            <div class="features-grid">
                <div class="feature-card">
                    <img src="{{ asset('images/icons/cartao-icon.svg') }}" alt="Ellon Sports Banner" width="40"
                         height="30">
                    <div class="featureGroup">
                        <p>Compra Segura</p>
                        <span>Nosso site utiliza tecnologias avançadas de segurança para garantir a proteção dos seus dados
                            e transações.</span>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('images/icons/transporte-icon.svg') }}" alt="Ellon Sports Banner" width="40"
                         height="30">
                    <div class="featureGroup">
                        <p>Entrega Garantida</p>
                        <span>Garantimos a entrega do seu pedido no prazo informado. Acompanhamos cada etapa para que você
                            receba tudo certinho.</span>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('images/icons/presente-icon.svg') }}" alt="Ellon Sports Banner" width="40"
                         height="30">
                    <div class="featureGroup">
                        <p>Cliente Satisfeito</p>
                        <span>Se o produto não atender às suas expectativas, garantimos a devolução do valor ou troca do
                            item,
                            sem complicações.</span>
                    </div>
                </div>
                <div class="feature-card">
                    <img src="{{ asset('images/icons/telefone-icon.svg') }}" alt="Ellon Sports Banner" width="40"
                         height="30">
                    <div class="featureGroup">
                        <p>Suporte ao Cliente</p>
                        <span>Nosso time de suporte está à disposição para tirar dúvidas e oferecer ajuda durante toda a
                            sua
                            jornada de compra.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="reviews">
        <div class="alignSection">
            <h2 class="title">O que falam sobre nós</h2>
            <div class="reviews-grid">
                <!-- Review 1 -->
                <div class="review-card">
                    <p class="message">"Excelente qualidade e atendimento. Chegou antes do prazo!"</p>
                    <div class="info">
                        <span class="author">João Silva</span>
                        <span class="date">10/01/2025</span>
                    </div>
                    <div class="stars">★★★★★</div>
                </div>

                <!-- Review 2 -->
                <div class="review-card">
                    <p class="message">"Produtos incríveis, super recomendo! Voltarei a comprar."</p>
                    <div class="info">
                        <span class="author">Ana Costa</span>
                        <span class="date">08/01/2025</span>
                    </div>
                    <div class="stars">★★★★★</div>
                </div>

                <!-- Review 3 -->
                <div class="review-card">
                    <p class="message">"O produto corresponde às expectativas. Muito bom!"</p>
                    <div class="info">
                        <span class="author">Carlos Pereira</span>
                        <span class="date">05/01/2025</span>
                    </div>
                    <div class="stars">★★★★☆</div>
                </div>

                <!-- Review 4 -->
                <div class="review-card">
                    <p class="message">"Gostei bastante, mas poderia ter mais opções de frete."</p>
                    <div class="info">
                        <span class="author">Beatriz Almeida</span>
                        <span class="date">03/01/2025</span>
                    </div>
                    <div class="stars">★★★★☆</div>
                </div>
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
