@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/order_list.css') !!}">
@section('content')
    <main class="minhaConta">
        <div class="container">
            <nav class="sidebar">
                <ul>
                    <li><a href="#">Minha Conta</a></li>
                    <li><a href="#">Meus Pedidos</a></li>
                    <li><a href="#">Meus Favoritos</a></li>
                    <li><a href="#">Endereços</a></li>
                    <li><a href="#">Meus Dados</a></li>
                </ul>
            </nav>

            <section class="mainContent">
                <header class="userGreeting">
                    <h1>Olá, Ivana</h1>
                    <p>Aqui você encontra todas as informações relacionadas à sua conta, como acompanhar seus últimos pedidos, adicionar novos endereços ...</p>
                </header>

                <div class="actionButtons">
                    <button>Meus Dados</button>
                    <button>Meus Pedidos</button>
                    <button>Endereços</button>
                    <button>Favoritos</button>
                </div>

                <section class="latestOrders">
                    <h2>Últimos Pedidos</h2>
                    <div class="orders">
                        <!-- Repetir este bloco para cada pedido -->
                        <div class="orderCard">
                            <div class="orderInfo">
                                <p><strong>Número do Pedido:</strong> #1010453106</p>
                                <p><strong>Pagamento:</strong> PAGUE VIA PIX</p>
                                <p><strong>Data:</strong> 29/03/2025 20:46:09</p>
                                <p><strong>Valor Total:</strong> R$ 90,31</p>
                                <p><strong>Status:</strong> <span class="statusEntregue">ENTREGUE</span></p>
                            </div>
                            <div class="orderActions">
                                <button>Ver Pedido</button>
                                <button>Rastrear Pedido</button>
                                <button>Contatar Suporte</button>
                            </div>
                            <div class="deliveryDate">Produto Entregue - 04/04/2025</div>
                        </div>
                        <!-- ... outros pedidos ... -->
                    </div>
                    <button class="viewAll">Ver Todos</button>
                </section>

                <section class="addresses">
                    <h2>Endereços</h2>
                    <div class="addressCards">
                        <div class="addressCard">
                            <h3>Endereço de Entrega Padrão</h3>
                            <address>
                                Andre Henrique<br>
                                Rua Francisco Mariano Centro 483<br>
                                Alfenas, MG, BR - 37130-107<br>
                                Tel: (35) 9915-82521
                            </address>
                        </div>
                        <div class="addressCard">
                            <h3>Endereço de Cobrança Padrão</h3>
                            <address>
                                Andre Henrique<br>
                                Rua Francisco Mariano Centro 483<br>
                                Alfenas, MG, BR - 37130-107<br>
                                Tel: (35) 9915-82521
                            </address>
                        </div>
                    </div>
                </section>

                <section class="userData">
                    <h2>Meus Dados</h2>
                    <p><strong>Nome:</strong> Ivana Manzo</p>
                    <p><strong>Email:</strong> deda37198@gmail.com</p>
                    <div class="userActions">
                        <button class="edit">Editar</button>
                        <button class="changePassword">Mudar Senha</button>
                        <button class="deleteAccount">Excluir Minha Conta</button>
                    </div>
                </section>
            </section>
        </div>
    </main>
@endsection
