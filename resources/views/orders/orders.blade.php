@extends('layouts.app')
@section('title', 'Ellon Sports | Meus Pedidos')
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
                                <img width="56" height="56" src="{{ asset('images/icons/order-list.svg') }}" alt="Pedidos">
                            </div>
                            <div class="userInfo">
                                <h1>Meus Pedidos</h1>
                                <p>Acompanhe todos os seus pedidos</p>
                            </div>
                        </div>
                    </header>

                    <div class="meusPedidos">
                        <div class="card orderCard-detalhado">
                            <div class="orderHeader-detalhado">
                                <div class="orderInfo-detalhado">
                                    <div>
                                        <strong>Número do Pedido</strong>
                                        <div>#1010453106</div>
                                    </div>
                                    <div>
                                        <strong>Pagamento</strong>
                                        <div>PAGUE VIA PIX</div>
                                    </div>
                                    <div>
                                        <strong>Data</strong>
                                        <div>29/03/2025 20:46:09</div>
                                    </div>
                                    <div>
                                        <strong>Valor Total</strong>
                                        <div>R$ 90,31</div>
                                    </div>
                                    <div>
                                        <strong>Status:</strong>
                                        <span class="statusEntregue">ENTREGUE</span>
                                    </div>
                                </div>
                                <div class="orderActions-detalhado">
                                    <button class="btnPrimary-green">VER PEDIDO</button>
                                    <button class="btnSecondary-green">RASTREAR PEDIDO</button>
                                    <button class="btnOutline-green">CONTATAR SUPORTE</button>
                                </div>
                            </div>
                            <div class="orderProgress">
                                <div class="progressStep done">
                                    <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="stepLabel">Pedido Realizado</div>
                                    <div class="stepDate">(2025-03-29 23:46:09)</div>
                                </div>
                                <div class="progressLine"></div>
                                <div class="progressStep done">
                                    <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="stepLabel">Em Separação</div>
                                    <div class="stepDate">(2025-03-29 23:50:07)</div>
                                </div>
                                <div class="progressLine"></div>
                                <div class="progressStep done">
                                    <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="stepLabel">Produto Enviado</div>
                                    <div class="stepDate">(2025-03-31 12:20:50)</div>
                                </div>
                                <div class="progressLine"></div>
                                <div class="progressStep done">
                                    <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="stepLabel">Produto Entregue</div>
                                    <div class="stepDate">(2025-04-04 17:47:34)</div>
                                </div>
                            </div>
                        </div>
                        <div class="card orderCard-detalhado">
                            <div class="orderHeader-detalhado">
                                <div class="orderInfo-detalhado">
                                    <div>
                                        <strong>Número do Pedido</strong>
                                        <div>#1010453106</div>
                                    </div>
                                    <div>
                                        <strong>Pagamento</strong>
                                        <div>PAGUE VIA PIX</div>
                                    </div>
                                    <div>
                                        <strong>Data</strong>
                                        <div>29/03/2025 20:46:09</div>
                                    </div>
                                    <div>
                                        <strong>Valor Total</strong>
                                        <div>R$ 90,31</div>
                                    </div>
                                    <div>
                                        <strong>Status:</strong>
                                        <span class="statusEntregue">ENTREGUE</span>
                                    </div>
                                </div>
                                <div class="orderActions-detalhado">
                                    <button class="btnPrimary-green">VER PEDIDO</button>
                                    <button class="btnSecondary-green">RASTREAR PEDIDO</button>
                                    <button class="btnOutline-green">CONTATAR SUPORTE</button>
                                </div>
                            </div>
                            <div class="orderProgress">
                                <div class="progressStep done">
                                    <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="stepLabel">Pedido Realizado</div>
                                    <div class="stepDate">(2025-03-29 23:46:09)</div>
                                </div>
                                <div class="progressLine"></div>
                                <div class="progressStep done">
                                    <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="stepLabel">Em Separação</div>
                                    <div class="stepDate">(2025-03-29 23:50:07)</div>
                                </div>
                                <div class="progressLine"></div>
                                <div class="progressStep done">
                                    <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="stepLabel">Produto Enviado</div>
                                    <div class="stepDate">(2025-03-31 12:20:50)</div>
                                </div>
                                <div class="progressLine"></div>
                                <div class="progressStep done">
                                    <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    <div class="stepLabel">Produto Entregue</div>
                                    <div class="stepDate">(2025-04-04 17:47:34)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection 