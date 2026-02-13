@extends('layouts.app')
@section('title', 'Gabaritei Concursos')
@section('head_content')
<link rel="stylesheet" href="{!! asset('assets/css/home.css') !!}">
@endsection
@section('content')
    <div class="homePage">
        <section class="heroSection">
            <img class="heroBannerImage" src="{{ asset('images/banner.png') }}" alt="Banner Gabaritei Concursos">
        </section>

        <section class="launchSection">
            <div class="sectionInner">
                <h2 class="sectionTitle">Lançamentos</h2>
                <div class="productGrid">
                    @foreach(['frete' => ['Frete grátis', 'transporte.svg'], 'atualizado' => ['Atualizado pós-edital', 'verificado.svg']] as $type => $label)
                    @for($i = 0; $i < 2; $i++)
                        <article class="productCard">
                            <div class="productImageWrapper">
                                <img src="{{ asset('images/banner.png') }}" alt="Apostila Banco do Brasil - Escriturário e Agente Comercial">
                            </div>
                            <div class="productInfo">
                                <span class="productBadge productBadge{{ $type === 'frete' ? 'Frete' : 'Atualizado' }}">
                                    <img class="productBadgeIcon" src="{{ asset('images/icons/' . $label[1]) }}" alt="">
                                    {{ $label[0] }}
                                </span>
                                <p class="productName">Apostila Banco do Brasil - Escriturário e Agente Comercial</p>
                                <div class="productPriceGroup">
                                    <span class="productOldPrice">de R$ 149,00</span>
                                    <span class="productPrice">R$ 34,88</span>
                                    <span class="productInstallment">ou 3X de R$ 23 sem juros</span>
                                </div>
                            </div>
                        </article>
                    @endfor
                    @endforeach
                </div>
            </div>
        </section>

        <section class="whySection">
            <div class="sectionInner">
                <h2 class="sectionTitle sectionTitleCenter">Porque a Gabaritei tem os materiais que mais aprovam?</h2>
                <div class="whyGrid">
                    <article class="whyCard">
                        <div class="whyIconWrap">
                            <img class="whyIcon" src="{{ asset('images/icons/urso.svg') }}" alt="">
                        </div>
                        <p class="whyText">Sempre alinhado ao edital, com atualizações rápidas a cada mudança.</p>
                    </article>
                    <article class="whyCard">
                        <div class="whyIconWrap">
                            <img class="whyIcon" src="{{ asset('images/icons/banco.svg') }}" alt="">
                        </div>
                        <p class="whyText">Foco no que mais cai, sem perder tempo com conteúdos irrelevantes.</p>
                    </article>
                    <article class="whyCard">
                    <div class="whyIconWrap">
                            <img class="whyIcon" src="{{ asset('images/icons/oficial.svg') }}" alt="">
                        </div>
                        <p class="whyText">Explicações claras e objetivas, facilitando o aprendizado.</p>
                    </article>
                    <article class="whyCard">
    
                    <div class="whyIconWrap">
                            <img class="whyIcon" src="{{ asset('images/icons/pagamento.svg') }}" alt="">
                        </div>
                        <p class="whyText">Conteúdo eficiente, ideal para quem tem pouco tempo para estudar.</p>
                    </article>
                </div>
            </div>
        </section>

        <section class="dealSection">
            <div class="sectionInner">
                <div class="dealTitleCard">
                    <p class="dealTitle">Desconto especial do dia! 🔥</p>
                </div>
                <div class="dealContent">
                    <div class="dealImageWrapper">
                        <img src="https://www.figma.com/api/mcp/asset/4d3b0ad5-c8d3-4058-8845-4feb75c2f065" alt="Apostila Banco do Brasil">
                    </div>
                    <div class="dealInfo">
                        <h3 class="dealProductTitle">Banco do Brasil - Escriturário e Agente Comercial</h3>
                        <div class="dealPriceBlock">
                            <span class="dealTag">Pré-venda - 20/02</span>
                            <p class="dealOldPrice">de R$ 525,60 por</p>
                            <p class="dealPrice">R$ 169,00</p>
                            <p class="dealInstallment">ou 12x de R$14,08 sem juros</p>
                        </div>
                        <ul class="dealList">
                            <li>Lorem Ipsum é simplesmente uma simulação de texto</li>
                            <li>Lorem Ipsum é simplesmente uma simulação de texto</li>
                            <li>Lorem Ipsum é simplesmente uma simulação de texto</li>
                        </ul>
                        <button class="dealButton" type="button">Comprar agora</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="materialsSection">
            <div class="sectionInner">
                <h2 class="sectionTitle sectionTitleCenter">Materiais para os principais concursos do país</h2>
                <div class="materialsGrid">
                    <article class="materialCard">
                        <img class="materialIcon" src="{{ asset('images/icons/pagamento.svg') }}" alt="">
                        <div class="materialInfo">
                            <p class="materialTitle">Receita Federal</p>
                            <span class="materialTag">Fiscal</span>
                        </div>
                    </article>
                    <article class="materialCard">
                        <img class="materialIcon" src="{{ asset('images/icons/banco.svg') }}" alt="">
                        <div class="materialInfo">
                            <p class="materialTitle">Banco do Brasil</p>
                            <span class="materialTag">Bancária</span>
                        </div>
                    </article>
                    <article class="materialCard">
                        <img class="materialIcon" src="{{ asset('images/icons/oficial.svg') }}" alt="">
                        <div class="materialInfo">
                            <p class="materialTitle">Polícia Federal</p>
                            <span class="materialTag">Policial</span>
                        </div>
                    </article>
                    <article class="materialCard">
                        <img class="materialIcon" src="{{ asset('images/icons/grupo.svg') }}" alt="">
                        <div class="materialInfo">
                            <p class="materialTitle">INSS</p>
                            <span class="materialTag">Previdenciária</span>
                        </div>
                    </article>
                    <a class="materialMoreCard" href="#">
                        <span>Ver todos</span>
                        <img class="materialMoreIcon" src="{{ asset('images/icons/diagonal_flecha.svg') }}" alt="">
                    </a>
                </div>
            </div>
        </section>

        <section class="bestValueSection">
            <div class="sectionInner">
                <h2 class="sectionTitle">O melhor custo-benefício</h2>
                <div class="productGrid productGridTall">
                    @for($i = 0; $i < 4; $i++)
                        <article class="productCard productCardTall">
                            <div class="productImageWrapper">
                                <img src="https://www.figma.com/api/mcp/asset/4d3b0ad5-c8d3-4058-8845-4feb75c2f065" alt="Apostila Banco do Brasil">
                            </div>
                            <div class="productInfo">
                                <span class="productBadge">
                                    <img class="productBadgeIcon" src="{{ asset('images/icons/transporte.svg') }}" alt="">
                                    Frete grátis
                                </span>
                                <p class="productName">Apostila Banco do Brasil - Escriturário e Agente Comercial</p>
                                <div class="productPriceGroup">
                                    <span class="productOldPrice">de R$ 149,00</span>
                                    <span class="productPrice">R$ 34,88</span>
                                    <span class="productInstallment">ou 3X de R$ 23 sem juros</span>
                                </div>
                            </div>
                        </article>
                    @endfor
                </div>
            </div>
        </section>

        <section class="panoramaSection">
            <div class="sectionInner">
                <div class="panoramaHeader">
                    <div class="panoramaTitleGroup">
                        <h2 class="sectionTitle sectionTitleCenter">Panorama dos Concursos</h2>
                        <p class="sectionSubtitle">Fique por dentro do que impacta sua preparação para concursos públicos.</p>
                    </div>
                    <div class="panoramaFilters">
                        <button class="panoramaFilter panoramaFilterActive" type="button">Todos</button>
                        <button class="panoramaFilter" type="button">Artigos</button>
                        <button class="panoramaFilter" type="button">Notícias</button>
                        <button class="panoramaFilter" type="button">Editais</button>
                    </div>
                </div>
                <div class="panoramaGrid">
                    <article class="panoramaCard">
                        <div class="panoramaCardTop">
                            <span class="panoramaTag">Artigo</span>
                            <span class="panoramaDate">18 jan</span>
                        </div>
                        <p class="panoramaTitle">Como organizar um plano de estudos eficiente</p>
                        <div class="panoramaAuthor">
                            <img class="panoramaAuthorIcon" src="{{ asset('images/icons/profile.svg') }}" alt="">
                            <span class="panoramaAuthorName">Roberto Ramos</span>
                        </div>
                    </article>
                    <article class="panoramaCard">
                        <div class="panoramaCardTop">
                            <span class="panoramaTag">Notícia</span>
                            <span class="panoramaDate">13 jan</span>
                        </div>
                        <p class="panoramaTitle">Governo autoriza novo concurso para Nível Médio</p>
                    </article>
                    <article class="panoramaCard">
                        <div class="panoramaCardTop">
                            <span class="panoramaTag">Artigo</span>
                            <span class="panoramaDate">8 jan</span>
                        </div>
                        <p class="panoramaTitle">Dicas práticas para melhorar seu desempenho</p>
                        <div class="panoramaAuthor">
                            <img class="panoramaAuthorIcon" src="{{ asset('images/icons/profile.svg') }}" alt="">
                            <span class="panoramaAuthorName">Cintia Garcia</span>
                        </div>
                    </article>
                    <article class="panoramaCard">
                        <div class="panoramaCardTop">
                            <span class="panoramaTag">Edital</span>
                            <span class="panoramaDate">2 jan</span>
                        </div>
                        <p class="panoramaTitle">Edital Receita Federal – Auditor e Analista</p>
                    </article>
                    <a class="panoramaMoreCard" href="#">
                        <span>Ver todos</span>
                        <img class="panoramaMoreIcon" src="{{ asset('images/icons/diagonal_flecha.svg') }}" alt="">
                    </a>
                </div>
            </div>
        </section>

        <section class="newsletterSection">
            <div class="newsletterInner">
                <div class="newsletterText">
                    <h3>Fique por dentro das principais novidades dos concursos</h3>
                    <p>Enviamos diretamente ao seu e-mail</p>
                </div>
                <form class="newsletterForm">
                    <input class="newsletterInput" type="email" placeholder="Digite o seu e-mail">
                    <button class="newsletterButton" type="submit">Enviar</button>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('footer_content')

@endsection

