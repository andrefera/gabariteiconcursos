@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
@section('head_content')
<link rel="stylesheet" href="{!! asset('assets/css/home.css') !!}">
@endsection
@section('content')
    <section class="s-slide-hero">
        <div class="swiper-container mySwiperBanner">
            <div class="swiper-wrapper">
                <!-- Slides aqui -->
                <div class="swiper-slide">
                    <img src="{{ asset('images/banner2.jpg') }}" alt="Ellon Sports Banner">
                </div>
                <!-- Adicione mais slides conforme necessário -->
            </div>
            <div class="swiper-pagination swiper-pagination-banner"></div>
        </div>
    </section>
    <section class="teamSection">
        <div class="alignSection">
            <h2 class="title">Navegue por times</h2>
            <div class="swiper-container mySwiperTeams">
                <div class="swiper-wrapper teamGroup">
                    @if(count($brazilianTeams) > 0)
                        @foreach($brazilianTeams as $team)
                            <div class="swiper-slide">
                                <a href="/time/{{ $team['url'] }}" class="team">
                                    @if($team['logo'])
                                        <img src="{{ $team['logo'] }}" alt="{{ $team['name'] }}">
                                    @else
                                        <img src="{{ asset('images/teams/default.png') }}" alt="{{ $team['name'] }}">
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/botafogo.png') }}" alt="Botafogo">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/atletico.png') }}" alt="Atlético">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/cruzeiro.png') }}" alt="Cruzeiro">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/corinthians.png') }}" alt="Corinthians">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/flamengo.png') }}" alt="Flamengo">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/palmeiras.png') }}" alt="Palmeiras">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/vasco.png') }}" alt="Vasco">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/saopaulo.png') }}" alt="São Paulo">
                            </a>
                        </div>
                        <div class="swiper-slide">
                            <a href="/" class="team">
                                <img src="{{ asset('images/teams/fluminense.png') }}" alt="Fluminense">
                            </a>
                        </div>
                    @endif
                </div>
                <div class="swiper-pagination swiper-pagination-teams"></div>
            </div>
        </div>
    </section>

    <section class="destaques">
        <div class="alignSection">
            <h2 class="title">Destaques</h2>
            <div class="grid swiper-container mySwiper">
                <div class="swiper-wrapper">
                    @if(count($products) > 0)
                        @foreach($products as $product)
                            <div class="card swiper-slide">
                                <a href="/shirt/{{ $product['url'] }}" class="card-link">
                                    <div class="cardContent">
                                        @if($product['discount_percentage'])
                                            <span class="badge">{{ $product['discount_percentage'] }}</span>
                                        @endif
                                        <img
                                            src="{{ $product['image'] ?? asset('images/icon.png') }}"
                                            alt="{{ $product['name'] }}">
                                    </div>
                                    <div class="info">
                                        <h3>{{ $product['name'] }}</h3>
                                        <div>
                                            <span class="price">{{ $product['special_price'] ?? $product['price'] }}</span>
                                            @if($product['special_price'])
                                                <span class="old-price">{{ $product['price'] }}</span>
                                            @endif
                                        </div>
                                        <div>{{ $product['installment_price'] }}</div>
                                        <div class="stars">★★★★★ (5)</div>
                                        <span class="free-shipping">FRETE GRÁTIS</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="no-products">
                            <p>Nenhum produto disponível no momento.</p>
                        </div>
                    @endif
                </div>
                <div class="swiper-pagination swiper-pagination-depoimentos"></div>
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
            <div class="grid swiper-container mySwiperEuropeus">
                <div class="swiper-wrapper">
                    @if(count($europeanProducts) > 0)
                        @foreach($europeanProducts as $product)
                            <div class="card swiper-slide">
                                <a href="/shirt/{{ $product['url'] }}" class="card-link">
                                    <div class="cardContent">
                                        @if($product['discount_percentage'])
                                            <span class="badge">{{ $product['discount_percentage'] }}</span>
                                        @endif
                                        <img
                                            src="{{ $product['image'] ?? asset('images/icon.png') }}"
                                            alt="{{ $product['name'] }}">
                                    </div>
                                    <div class="info">
                                        <h3>{{ $product['name'] }}</h3>
                                        <div>
                                            <span class="price">{{ $product['special_price'] ?? $product['price'] }}</span>
                                            @if($product['special_price'])
                                                <span class="old-price">{{ $product['price'] }}</span>
                                            @endif
                                        </div>
                                        <div>{{ $product['installment_price'] }}</div>
                                        <div class="stars">★★★★★ (5)</div>
                                        <span class="free-shipping">FRETE GRÁTIS</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="no-products">
                            <p>Nenhum produto de times europeus disponível no momento.</p>
                        </div>
                    @endif
                </div>
                <div class="swiper-pagination swiper-pagination-europeus"></div>
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
            <div class="reviews-grid reviews-mobile-swiper">
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

@endsection
@section('footer_content')
<link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}?v={{ env('STATIC_VERSION', time()) }}">
<script src="{{ asset('assets/js/swiper.min.js') }}?v={{ env('STATIC_VERSION', time()) }}"></script>
<script src="{{ asset('assets/js/home.min.js') }}?v={{ env('STATIC_VERSION', time()) }}"></script>
@endsection

