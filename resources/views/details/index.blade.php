@extends('layouts.app')
@section('title', $product->name . ' | Gabaritei Concursos')
@section('head_content')
<link rel="stylesheet" href="{!! asset('assets/css/detail.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/plugins.css') !!}">
@endsection

@section('content')
<div class="detailPage">
    <div class="detailInner">
        <nav class="detailBreadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Início</a>
            <span class="detailBreadcrumbSep">▸</span>
            <span class="detailBreadcrumbCurrent">{{ $product->name }}</span>
        </nav>

        <section class="detailHero {{ (empty($product->images) || count($product->images) <= 1) ? 'detailHero--noThumbs' : '' }}">
            <div class="detailGalleryCol">
                @if(!empty($product->images) && count($product->images) > 1)
                    <div class="detailThumbnails">
                        @foreach($product->images as $index => $image)
                            <button type="button" class="detailThumb {{ $index === 0 ? 'is-active' : '' }}" data-index="{{ $index }}" aria-label="Ver imagem {{ $index + 1 }}">
                                <img src="{{ $image->url }}" alt="">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="detailImageCol">
                @if(isset($product->images[0]))
                    <div class="detailImageMain">
                        <img id="mainImage" src="{{ $product->images[0]->url }}" alt="{{ $product->name }}" width="400" height="520">
                    </div>
                @endif
            </div>

            <div class="detailInfoCol">
                <h1 class="detailTitle">{{ $product->name }}</h1>
                @if($product->sku)
                    <p class="detailCode">Código: {{ $product->sku }}</p>
                @endif

                @if($product->special_price && $product->discount_percentage)
                    <div class="detailBadge">{{ $product->discount_percentage }} de desconto</div>
                @endif

                <div class="detailPriceBlock">
                    @if($product->special_price)
                        <p class="detailPriceFrom">de {{ $product->price }}</p>
                    @endif
                    <p class="detailPrice">{{ $product->special_price ?? $product->price }}</p>
                    <p class="detailInstallment">{{ $product->installment_price }}</p>
                </div>

                @if(!empty($product->sizes))
                    <div class="detailVariantBlock">
                        <p class="detailVariantLabel">Tipo</p>
                        <div class="detailVariants">
                            @foreach($product->sizes as $size)
                                <label class="detailVariantOption">
                                    <input type="radio" name="variant" value="{{ $size->name }}" {{ $loop->first ? 'checked' : '' }}>
                                    <span>{{ $size->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="detailVariantBlock">
                        <p class="detailVariantLabel">Tipo</p>
                        <div class="detailVariants">
                            <label class="detailVariantOption">
                                <input type="radio" name="variant" value="Digital" checked>
                                <span>Digital</span>
                            </label>
                            <label class="detailVariantOption">
                                <input type="radio" name="variant" value="Impressa">
                                <span>Impressa</span>
                            </label>
                            <label class="detailVariantOption">
                                <input type="radio" name="variant" value="Combo">
                                <span>Combo</span>
                            </label>
                        </div>
                    </div>
                @endif

                <div class="detailActions">
                    <button type="button" class="detailBtnBuy">Comprar agora</button>
                </div>

                <ul class="detailTrust">
                    <li>
                        <img src="{{ asset('images/icons/transporte.svg') }}" alt="" width="24" height="24">
                        <span>Envio mais rápido do Brasil</span>
                    </li>
                    <li>
                        <img src="{{ asset('images/icons/verificado.svg') }}" alt="" width="24" height="24">
                        <span>Compra 100% Segura!</span>
                    </li>
                    <li>
                        <span class="detailTrustIcon">↻</span>
                        <span>Garantia de devolução do dinheiro em 7 dias</span>
                    </li>
                </ul>
            </div>
        </section>

        <section class="detailSpecs">
            <h2 class="detailSpecsTitle">Detalhes</h2>
            <dl class="detailSpecsList">
                <div class="detailSpecItem">
                    <dt>Material</dt>
                    <dd>Atualizado de acordo com Edital!</dd>
                </div>
                <div class="detailSpecItem">
                    <dt>Conteúdo</dt>
                    <dd>Teoria + Questões</dd>
                </div>
                <div class="detailSpecItem">
                    <dt>Página</dt>
                    <dd>500</dd>
                </div>
                <div class="detailSpecItem">
                    <dt>Capa</dt>
                    <dd>Flexível</dd>
                </div>
                <div class="detailSpecItem">
                    <dt>Editora</dt>
                    <dd>Gabaritei</dd>
                </div>
                <div class="detailSpecItem">
                    <dt>Bônus</dt>
                    <dd>Exclusivo Gabaritei! 😊</dd>
                </div>
            </dl>
            <a href="#" class="detailReadPages">
                <span class="detailReadPagesIcon">📖</span>
                Ler algumas páginas
            </a>
        </section>

        <section class="detailDescription">
            <h2 class="detailDescTitle">Descrição</h2>
            <div class="detailDescContent">
                @if($product->description)
                    {!! nl2br(e($product->description)) !!}
                @else
                    <p>Lorem Ipsum é simplesmente um texto fictício da indústria tipográfica e de impressão. Lorem Ipsum tem sido o texto fictício padrão da indústria desde os anos 1500.</p>
                @endif
            </div>
        </section>

        @if(!empty($related_products))
        <section class="detailRelated">
            <h2 class="detailRelatedTitle">Produtos relacionados</h2>
            <div class="detailRelatedGrid">
                @foreach($related_products as $related_product)
                    <a href="{{ $related_product['url'] }}" class="detailRelatedCard">
                        <div class="detailRelatedImageWrap">
                            @if($related_product['discount_percentage'] ?? null)
                                <span class="detailRelatedBadge">{{ $related_product['discount_percentage'] }}</span>
                            @endif
                            <img src="{{ $related_product['image'] }}" alt="{{ $related_product['name'] }}">
                        </div>
                        <div class="detailRelatedInfo">
                            <h3 class="detailRelatedName">{{ $related_product['name'] }}</h3>
                            <div class="detailRelatedPriceBlock">
                                @if($related_product['special_price'] ?? null)
                                    <span class="detailRelatedPrice">{{ $related_product['special_price'] }}</span>
                                    <span class="detailRelatedOldPrice">{{ $related_product['price'] }}</span>
                                @else
                                    <span class="detailRelatedPrice">{{ $related_product['price'] }}</span>
                                @endif
                            </div>
                            <span class="detailRelatedInstallment">{{ $related_product['installment_price'] }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>

<script>
    window.productStocks = {!! json_encode($stocks_by_size ?? []) !!};
    window.productId = {{ $product->id }};
    window.cartAddUrl = "{{ route('cart.add') }}";
    window.csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
</script>
<script src="{{ asset('assets/js/plugins.min.js') }}?v={{ config('app.static_version') }}"></script>
<script src="{{ asset('assets/js/detail.min.js') }}?v={{ config('app.static_version') }}"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var mainImage = document.getElementById('mainImage');
    var thumbs = document.querySelectorAll('.detailThumb');
    thumbs.forEach(function(btn) {
        btn.addEventListener('click', function() {
            thumbs.forEach(function(b) { b.classList.remove('is-active'); });
            this.classList.add('is-active');
            var img = this.querySelector('img');
            if (img && mainImage) {
                mainImage.src = img.src;
                mainImage.alt = img.alt || '';
            }
        });
    });

    function getSelectedVariant() {
        var radio = document.querySelector('input[name="variant"]:checked');
        return radio ? radio.value : null;
    }

    function addToCart(thenRedirect) {
        var variant = getSelectedVariant();
        if (!variant) {
            if (typeof showToast === 'function') {
                showToast('Atenção', 'Selecione uma opção (Digital, Impressa ou Combo).', 'warning');
            }
            return;
        }
        fetch(window.cartAddUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken
            },
            body: JSON.stringify({
                product_id: window.productId,
                size: variant,
                quantity: 1
            })
        })
        .then(function(r) { return r.json().then(function(data) { return { ok: r.ok, data: data }; }); })
        .then(function(result) {
            if (result.ok) {
                if (typeof showToast === 'function') showToast('Sucesso', 'Produto adicionado ao carrinho!', 'success');
                if (thenRedirect) window.location.href = '/cart';
            } else {
                if (typeof showToast === 'function') showToast('Erro', result.data.message || 'Erro ao adicionar.', 'error');
            }
        })
        .catch(function() {
            if (typeof showToast === 'function') showToast('Erro', 'Erro ao adicionar ao carrinho.', 'error');
        });
    }

    var btnBuy = document.querySelector('.detailBtnBuy');
    if (btnBuy) {
        btnBuy.addEventListener('click', function() {
            addToCart(true);
        });
    }
});
</script>
@endsection
