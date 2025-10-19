@extends('layouts.app')
@section('title', 'Ellon Sports | Carrinho de Compras')
<link rel="stylesheet" href="{!! asset('assets/css/cart.css') !!}">
@section('content')
    <section class="cartSection fade-in">
        <div class="alignSection">
            @if(!$cart || empty($cart->products))
                <div class="empty-cart">
                    <div class="empty-cart__illustration" aria-hidden="true">
                        <!-- Simple cart outline icon -->
                        <svg width="96" height="96" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3h1.6c.46 0 .87.31.98.75L6.7 8.5H19a1 1 0 0 1 .98 1.2l-1.1 5.5a2 2 0 0 1-1.96 1.6H9.3a2 2 0 0 1-1.95-1.43L5.2 6H3" stroke="#FF7C00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="9" cy="20" r="1.5" stroke="#333" stroke-width="1.5"/>
                            <circle cx="17" cy="20" r="1.5" stroke="#333" stroke-width="1.5"/>
                        </svg>
                    </div>
                    <h1>Seu carrinho está vazio</h1>
                    <p class="empty-cart__subtitle">Você ainda não adicionou nenhum produto ao seu carrinho.</p>
                    <div class="empty-cart__ctas">
                        <a href="/camisas" class="btn-continue">Ver produtos</a>
                        <a href="/" class="link-secondary">Ir para a página inicial</a>
                    </div>
                </div>
            @else
                <h1>Carrinho de Compras ({{ $cart->totalProducts }})</h1>
                <div class="cart-content">
                    <div class="cart-list">
                        <div class="cart-list__header">
                            <span class="items">Item(s)</span>
                            <span>Quantidade</span>
                            {{--                    <span>Valor Unitário</span>--}}
                            <span>Valor Total</span>
                        </div>
                        @foreach($cart->products as $item)
                            <div class="cart-item-container" data-item-id="{{ $item->id }}">
                                <div class="cart-item-product">
                                    <img class="product-image"
                                         src="{{ asset($item->imageUrl) }}"
                                         alt="{{ $item->name }}">
                                    <p>
                                        <span>{{ $item->name }}</span>
                                        <small>Tamanho: {{ $item->size }}</small>
                                    </p>
                                </div>
                                <div class="cart-item-quantity-value">
                                    <div class="cart-item-quantity">
                                        <div class="quantity-controls">
                                            <button class="quantity-btn minus"
                                                    {{$item->quantity - 1 === 0 ? "disabled" : ""}} onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">
                                                -
                                            </button>
                                            <input type="text" value="{{ $item->quantity }}" id="quantity" class="quantity-input"
                                                   onchange="updateQuantity({{ $item->id }}, this.value)">
                                            <button class="quantity-btn plus"
                                                    onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">
                                                +
                                            </button>
                                        </div>
                                        <button class="remove-text" onclick="removeItem({{ $item->id }})">Excluir Item
                                        </button>
                                    </div>
                                    {{--                        <div class="cart-item-value">--}}
                                    {{--                            <div class="cart-item-content">--}}
                                    {{--                                @if($item->specialPrice && $item->specialPrice < $item->price)--}}
                                    {{--                                    <span class="original-price">R$ {{ number_format($item->price, 2, ',', '.') }}</span>--}}
                                    {{--                                    <span class="special-price">R$ {{ number_format($item->specialPrice, 2, ',', '.') }}</span>--}}
                                    {{--                                    @else--}}
                                    {{--                                    <span class="total-price">R$ {{ number_format($item->price, 2, ',', '.') }}</span>--}}
                                    {{--                                    @endif--}}
                                    {{--                            </div>--}}
                                    {{--                        </div>--}}
                                    <div class="cart-item-value">
                                        <div class="cart-item-content">
                                            @if($item->specialPrice && $item->specialPrice < $item->price)
                                                <span
                                                    class="original-price">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</span>
                                                <span
                                                    class="special-price">R$ {{ number_format($item->specialPrice * $item->quantity, 2, ',', '.') }}</span>
                                            @else
                                                <span
                                                    class="total-price">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="cart-resume">
                        <a href="/camisas" class="keep-buying">Continuar comprando</a>
                        <div class="cart-resume-container">
                            <h4>Resumo do pedido</h4>
                            <div class="divisor"></div>
                            <div class="subtotal-content">
                                <span>Subtotal ({{ $cart->totalProducts }} {{ $cart->totalProducts > 1 ? 'itens' : 'item' }})</span>
                                <span class="subtotal-value">R$ {{ number_format($cart->total, 2, ',', '.') }}</span>
                            </div>
                            @if($cart->discount)
                                <div class="discount-content">
                                    <span>Desconto</span>
                                    <span
                                        class="discount-value">- R$ {{ number_format($cart->discount, 2, ',', '.') }}</span>
                                </div>
                            @endif
                            @if($cart->shipping > 0)
                                <div class="shipping-content">
                                    <span>Frete</span>
                                    <span
                                        class="shipping-value">R$ {{ number_format($cart->shipping, 2, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="divisor"></div>
                            <div class="total-content">
                                <span>Total</span>
                                <div class="total-resume">
                                    <h6>R$ {{ number_format($cart->finalPrice, 2, ',', '.') }}</h6>
                                    @if(isset($cart->installments[4]))
                                        <h6 class="installment">4 x
                                            R$ {{ number_format($cart->installments[4], 2, ',', '.') }} s/ juros</h6>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn-continue btn-cart">
                                <span>Finalizar Compra</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
        .original-price {
            color: #ff0000;
            text-decoration: line-through;
            font-size: 0.9em;
        }

        .special-price {
            color: #000;
            font-weight: bold;
        }

        .discount-content {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 14px;
        }

        .discount-value {
            color: #ff0000;
            font-weight: bold;
        }

        .shipping-content {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 14px;
        }

        .cart-item-content {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }
    </style>

    <script src="https://unpkg.com/imask"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        const quantityMask = IMask(document.getElementById('quantity'), {
            mask: '00'
        });

    </script>
    @if($cart && !empty($cart->products))
        <script>
            function updateQuantity(itemId, newQuantity) {
                if (!newQuantity || newQuantity < 1) return;

                fetch(`/cart/item/${itemId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        quantity: newQuantity
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        }else if(data.msg){
                            Toastify({
                                text: data.msg,
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                stopOnFocus: true,
                                style: {
                                    background: "#dc3545",
                                    borderRadius: "4px",
                                    fontSize: "14px",
                                    padding: "12px 24px"
                                }
                            }).showToast();

                            setTimeout(() => {
                                window.location.reload();
                            }, 1000)
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }

            function removeItem(itemId) {
                if (!confirm('Tem certeza que deseja remover este item do carrinho?')) return;

                fetch(`/cart/item/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.cart) {
                            window.location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
    @endif
@endsection
