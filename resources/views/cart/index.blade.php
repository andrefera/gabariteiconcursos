@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/cart.css') !!}">
@section('content')
    <section class="cartSection fade-in">
        <div class="alignSection">
            <h1>Carrinho de Compras (1)</h1>
            <div class="cart-content">
                <div class="cart-list">
                    <div class="cart-list__header"><span class="items">Item(s)</span><span>Quantidade</span><span>Valor Unitário</span>
                    </div>
                    <div class="cart-item-container">
                        <div class="cart-item-product">
                            <img class="product-image"
                                src="{{ asset('https://promantos.com.br/cdn/shop/files/E0FFA9E0-E91B-40E8-95F9-4C95F7A592D7_600x.jpg?v=1731013907') }}"
                                alt="Apostila PF 2025">
                            <p><span>Apostila PF em PDF 2025 - Agente de Polícia</span><small>SKU:
                                    NV-024JH-24-PREP-PF-AGENTE-POLICIA-DIGITAL</small></p></div>
                        <div class="cart-item-quantity-value">
                            <div class="cart-item-quantity 0">
                                    <span data-sku="NV-024JH-24-PREP-PF-AGENTE-POLICIA-DIGITAL"
                                          data-name="Apostila PF em PDF 2025 - Agente de Polícia" data-price="102.90"
                                          data-qty="1" class="remove-text btn_exclude">Excluir Item</span></div>
                            <div class="cart-item-value">
                                <div class="cart-item-content"><span class="total-price">R$&nbsp;102,90</span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-resume"><a href="https://www.novaconcursos.com.br/" class="keep-buying">Continuar
                        comprando</a>
                    <div class="cart-resume-container"><h4>Resumo do pedido</h4>
                        <div class="divisor"></div>
                        <div class="subtotal-content"><span>Subtotal (1 item)</span><span class="subtotal-value">R$&nbsp;102,90</span>
                        </div>
                        <div class="divisor"></div>
                        <div class="total-content"><span>Total</span>
                            <div class="total-resume"><h6>R$&nbsp;102,90</h6><h6 class="installment">10 x R$&nbsp;10,29
                                    s/ juros</h6></div>
                        </div>
                        <button class="btn-continue btn-cart" type="button"><span>Continuar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
