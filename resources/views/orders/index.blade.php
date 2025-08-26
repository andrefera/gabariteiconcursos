@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/order_list.css') !!}">
@section('content')
    <div class="alignSection">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="#">Início</a></li>
                <li class="active">Minha Conta</li>
            </ol>
        </nav>
    </div>
    <main class="minhaConta">
        <div class="alignSection">
            <div class="container">
                <nav class="sidebar">
                    <ul>
                        <li>
                            <a href="{{ route('profile.index') }}" class="active">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-profile.svg') }}"
                                     alt="Perfil">
                                Minha Conta
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.index') }}">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-order.svg') }}"
                                     alt="Pedido">
                                Meus Pedidos
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('orders.index') }}">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-address.svg') }}"
                                     alt="Endereço">
                                Meus Endereços
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('orders.data') }}">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-data.svg') }}"
                                     alt="Dados">
                                Meus Dados
                            </a>
                        </li>
                    </ul>
                </nav>

                <section class="mainContent">
                    <header class="userGreeting">
                        <div class="group">
                            <div class="profileImage">
                                <img width="56" height="56" src="{{ asset('images/icons/profile-circle.svg') }}" alt="Perfil">
                            </div>
                            <div class="userInfo">
                            <h2>Olá, {{ $user['name'] ?? 'Usuário' }}</h2>
                            <p>Aqui você encontra todas as informações relacionadas à sua conta, como acompanhar seus
                            últimos pedidos, adicionar novos endereços ...</p>
                            </div>
                        </div>
                    </header>

                    <section class="card">
                        <div class="titleGroup">
                            <div class="subGroup">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-order.svg') }}"
                                     alt="Pedidos">
                                <h2>Últimos Pedidos</h2>
                            </div>
                        </div>
                        <div class="orders">
                            @if(count($recentOrders) > 0)
                                @foreach($recentOrders as $order)
                                    <div class="orderCard">
                                        <div class="orderHeader">
                                            <div class="orderInfo">
                                                <p><strong>Número do Pedido:</strong> #{{ $order['order_number'] }}</p>
                                                <p><strong>Pagamento:</strong> {{ $order['payment_method'] ?? 'N/A' }}</p>
                                                <p><strong>Data:</strong> {{ $order['created_at'] }}</p>
                                                <p><strong>Valor Total:</strong> {{ $order['total'] }}</p>
                                                <p><strong>Status:</strong>
                                                    @if(in_array($order['status'], ['Reembolsado', 'Cancelado']))
                                                        <span class="statusPendente">{{ $order['status'] }}</span>
                                                    @else
                                                        <span class="statusEntregue">{{ $order['status'] }}</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="orderActions">
                                                <button class="btnPrimary">Ver Pedido</button>
                                                <button class="btnSecondary">Rastrear Pedido</button>
                                            </div>
                                        </div>
                                        @if($order['delivered_at'])
                                            <div class="deliveryDate">
                                                <img width="22" height="16" src="{{ asset('images/icons/truck.svg') }}"
                                                     alt="Caminhão"> Produto Entregue <span
                                                    class="deliveryTime">{{ $order['delivered_at'] }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="no-orders">
                                    <p>Nenhum pedido encontrado.</p>
                                </div>
                            @endif
                        </div>

                    </section>
                    <div class="cardAlign">
                        <section class="card">
                            <div class="titleGroup">
                                <div class="subGroup">
                                    <img width="24" height="24" src="{{ asset('images/icons/mini-address.svg') }}"
                                         alt="Endereços">
                                    <h2>Endereços</h2>
                                </div>
                            </div>

                            <div class="addressCards">
                                @if(count($addresses) > 0)
                                    @foreach($addresses as $address)
                                        <div class="addressCard">
                                            <h3>{{ $address['type'] }}</h3>
                                            <div class="address">
                                                <strong>{{ $address['name'] }}</strong>
                                                {{ $address['street'] }}, {{ $address['number'] }}
                                                @if($address['complement'])
                                                    - {{ $address['complement'] }}
                                                @endif<br>
                                                {{ $address['city'] }}, {{ $address['state'] }}, BR - {{ $address['zipcode'] }}<br>
                                                @if($address['phone'])
                                                    <span class="phone">Tel: {{ $address['phone'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="no-addresses">
                                        <p>Nenhum endereço cadastrado.</p>
                                    </div>
                                @endif
                            </div>

                        </section>

                        <section class="card">
                            <div class="titleGroup">
                                <div class="subGroup">
                                    <img width="24" height="24" src="{{ asset('images/icons/mini-data.svg') }}"
                                         alt="Dados">
                                    <h2>Meus Dados</h2>
                                </div>
                            </div>

                            <div class="accessInfo">
                                <h3>Informações de Acesso</h3>

                                <div class="infoRow">
                                    <img class="icon" width="16" height="16" src="{{ asset('images/icons/new-profile-icon.svg') }}"
                                         alt="perfil">
                                    <span class="text">{{ $user['name'] ?? 'N/A' }}</span>
                                </div>

                                <div class="infoRow">
                                    <img class="icon" width="16" height="16" src="{{ asset('images/icons/new-mail-icon.svg') }}"
                                         alt="email">
                                    <span class="text">{{ $user['email'] ?? 'N/A' }}</span>
                                </div>

                                <div class="userActions">
                                    <a href="{{ route('orders.data') }}">
                                        <button class="edit">EDITAR</button>
                                    </a>
                                    <button class="changePassword">MUDAR SENHA</button>
                                    <button class="deleteAccount">EXCLUIR MINHA CONTA</button>
                                </div>
                            </div>
                        </section>
                </section>
            </div>
        </div>
        </div>
    </main>
@endsection
