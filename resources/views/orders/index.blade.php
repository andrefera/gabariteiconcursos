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
                            <a href="#">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-profile.svg') }}"
                                     alt="Perfil">
                                Minha Conta
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-order.svg') }}"
                                     alt="Pedido">
                                Meus Pedidos
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-address.svg') }}"
                                     alt="Endereço">
                                Meus Endereços
                            </a>
                        </li>
                        <li>
                            <a href="#">
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
                            <h2>Olá, André</h2>
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
                            <button class="viewAll">Ver Todos</button>
                        </div>
                        <div class="orders">
                            <div class="orderCard">
                                <div class="orderHeader">
                                    <div class="orderInfo">
                                        <p><strong>Número do Pedido:</strong> #1010453106</p>
                                        <p><strong>Pagamento:</strong> PAGUE VIA PIX</p>
                                        <p><strong>Data:</strong> 29/03/2025 20:46:09</p>
                                        <p><strong>Valor Total:</strong> R$ 90,31</p>
                                        <p><strong>Status:</strong> <span class="statusEntregue">ENTREGUE</span></p>
                                    </div>
                                    <div class="orderActions">
                                        <button class="btnPrimary">Ver Pedido</button>
                                        <button class="btnSecondary">Rastrear Pedido</button>
                                    </div>
                                </div>
                                <div class="deliveryDate">
                                    <img width="22" height="16" src="{{ asset('images/icons/truck.svg') }}"
                                         alt="Caminhão"> Produto Entregue <span
                                        class="deliveryTime">04/04/2025 14:47:34</span>
                                </div>
                            </div>
                            <div class="orderCard">
                                <div class="orderHeader">
                                    <div class="orderInfo">
                                        <p><strong>Número do Pedido:</strong> #1010453106</p>
                                        <p><strong>Pagamento:</strong> PAGUE VIA PIX</p>
                                        <p><strong>Data:</strong> 29/03/2025 20:46:09</p>
                                        <p><strong>Valor Total:</strong> R$ 90,31</p>
                                        <p><strong>Status:</strong> <span
                                                class="statusPendente">Aguardando Pagamento</span></p>
                                    </div>
                                    <div class="orderActions">
                                        <button class="btnPrimary">Ver Pedido</button>
                                        <button class="btnSecondary">Rastrear Pedido</button>
                                    </div>
                                </div>
                                <div class="deliveryDate">
                                    <img width="22" height="16" src="{{ asset('images/icons/truck.svg') }}"
                                         alt="Caminhão"> Produto Entregue <span
                                        class="deliveryTime">04/04/2025 14:47:34</span>
                                </div>
                            </div>
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
                                <button class="viewAll">Ver Todos</button>
                            </div>

                            <div class="addressCards">
                                <div class="addressCard">
                                    <h3>Endereço de Entrega Padrão</h3>
                                    <div class="address">
                                        <strong>Andre Henrique</strong>
                                        Rua Francisco Mariano Centro 438<br>
                                        Alfenas, MG, BR - 37130-107<br>
                                        <span class="phone">Tel: (35) 9915-82521</span>
                                    </div>
                                </div>
                                <div class="addressCard">
                                    <h3>Endereço de Cobrança Padrão</h3>
                                    <div class="address">
                                        <strong>Andre Henrique</strong>
                                        Rua Francisco Mariano Centro 438<br>
                                        Alfenas, MG, BR - 37130-107<br>
                                        <span class="phone">Tel: (35) 9915-82521</span>
                                    </div>
                                </div>
                            </div>

                        </section>

                        <section class="card">
                            <div class="titleGroup">
                                <div class="subGroup">
                                    <img width="24" height="24" src="{{ asset('images/icons/mini-data.svg') }}"
                                         alt="Dados">
                                    <h2>Meus Dados</h2>
                                </div>
                                <button class="viewAll">Ver Todos</button>
                            </div>

                            <div class="accessInfo">
                                <h3>Informações de Acesso</h3>

                                <div class="infoRow">
                                    <img class="icon" width="16" height="16" src="{{ asset('images/icons/new-profile-icon.svg') }}"
                                         alt="perfil">
                                    <span class="text">Ivana Manzo</span>
                                </div>

                                <div class="infoRow">
                                    <img class="icon" width="16" height="16" src="{{ asset('images/icons/new-mail-icon.svg') }}"
                                         alt="email">
                                    <span class="text">dede37189@gmail.com</span>
                                </div>

                                <div class="userActions">
                                    <button class="edit">EDITAR</button>
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
