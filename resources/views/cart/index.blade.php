@extends('layouts.app')
@section('title', 'Gabaritei Concursos | Carrinho de Compras')
<link rel="stylesheet" href="{!! asset('assets/css/cart.css') !!}">
@section('content')
<div class="cart-page">
  <div class="container">
    <section class="listNavbar" aria-labelledby="page-title">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}" class="breadcrumbLink">Início</a>
            <span class="breadcrumbSep"><img src="{{ asset('images/breadcrumb.svg') }}" alt=""></span>
            <span class="breadcrumbCurrent">Meu carrinho</span>
        </nav>
      </section>

    <div class="cart-layout">
      <main class="cart-main">
        <h2 class="section-title">Dados de entrega</h2>

        <form class="delivery-form" aria-label="Dados de entrega">
          <div class="grid-2">
            <label class="input-group">
              <span class="label">Nome completo</span>
              <input type="text" value="Sara Oliveira" />
            </label>
            <label class="input-group">
              <span class="label">Telefone</span>
              <input type="text" value="(00) 0000-0000" />
            </label>

            <label class="input-group">
              <span class="label">CEP</span>
              <input type="text" value="00.000-000" />
            </label>
            <label class="input-group">
              <span class="label">Endereço</span>
              <input type="text" value="Rua Lorem Ipsum" />
            </label>

            <label class="input-group">
              <span class="label">Número</span>
              <input type="text" value="100" />
            </label>
            <label class="input-group">
              <span class="label">Bairro</span>
              <input type="text" value="Lorem ipsum" />
            </label>

            <label class="input-group">
              <span class="label">Complemento</span>
              <input type="text" value="Lorem ipsum" />
            </label>
            <label class="input-group">
              <span class="label">Cidade</span>
              <input type="text" value="Alfenas" />
            </label>

            <label class="input-group select-group">
              <span class="label">Estado</span>
              <select>
                <option>Minas Gerais</option>
              </select>
            </label>
          </div>
        </form>

        <h3 class="section-title">Frete e prazo</h3>
        <div class="shipping-options">
          <button class="shipping primary">
            <strong>Normal</strong>
            <span class="price">R$ 9,00</span>
            <small>Até 7 dias</small>
          </button>
          <button class="shipping">
            <strong>Expresso</strong>
            <span class="price">R$ 18,00</span>
            <small>Até 3 dias</small>
          </button>
        </div>

        <h3 class="section-title">Pagamento</h3>
        <div class="payment-options">
          <button class="payment primary">
            <strong>Pix</strong>
            <span class="price">R$ 120,00 à vista</span>
          </button>
          <button class="payment">
            <strong>Cartão de crédito</strong>
            <span class="price">À partir de R$ 164,00</span>
          </button>
          <button class="payment">
            <strong>Boleto</strong>
            <span class="price">R$ 122,00 à vista</span>
          </button>
        </div>

        <div class="payment-info card">
          <div class="icon"></div>
          <div class="info">
            <strong>Pix</strong>
            <p>O código Pix ficará disponível após a finalização da compra.</p>
          </div>
        </div>
      </main>

      <aside class="checkout-sidebar">
        <h2 class="sidebar-title">Resumo da compra</h2>

        <div class="cart-items">
          @for ($i = 0; $i < 2; $i++)
          <div class="cart-item">
            <div class="thumb">
              <img src="{{ asset('images/tabela.jfif') }}" alt="capa" />
            </div>
            <div class="meta">
              <p class="title">Apostila IBGE 2026 - Agente de Pesquisas e Mapeamento</p>
              <p class="price">R$ 40,00</p>
            </div>
            <div class="controls">
              <div class="qty">
                <button class="minus">−</button>
                <span class="count">1</span>
                <button class="plus">+</button>
              </div>
              <button class="remove">Remover</button>
            </div>
          </div>
          @endfor
        </div>

        <div class="coupon">
          <label class="coupon-input">
            <input type="text" placeholder="Digite o cupom" />
          </label>
          <button class="btn-apply">Aplicar cupom</button>
        </div>

        <div class="coupon-applied">
          <span>Cupom aplicado</span>
          <strong>GABARITEI10</strong>
        </div>

        <div class="totals">
          <div class="row"><span>Subtotal</span><span>R$ 80,00</span></div>
          <div class="row"><span>Frete</span><span>R$ 18,00</span></div>
          <div class="row"><span>Cupom de desconto</span><span class="discount">- R$ 8,00</span></div>
          <div class="total"><span>Valor total</span><strong>R$ 90,00</strong></div>
        </div>

        <button class="btn-checkout">Finalizar compra</button>
      </aside>
    </div>
  </div>
</div>
@endsection
