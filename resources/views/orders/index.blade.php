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
                            <a href="{{ route('orders.addresses') }}">
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
                                                <button class="btnPrimary order-detail-btn" data-order-id="{{ $order['id'] }}">Ver Pedido</button>
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
                        <section class="card" id="addresses">
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
                                    <button class="changePassword" onclick="openChangePasswordModal()">MUDAR SENHA</button>
                                    <button class="deleteAccount" onclick="openDeleteAccountModal()">EXCLUIR MINHA CONTA</button>
                                </div>
                            </div>
                        </section>
                </section>
            </div>
        </div>
        </div>
    </main>

    <!-- Container de Toast -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- Modal de Detalhes do Pedido -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detalhes do Pedido</h2>
                <span class="close" onclick="closeOrderModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div id="orderDetails">
                    <div class="loading">Carregando...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Mudança de Senha -->
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Mudar Senha</h2>
                <span class="close" onclick="closeChangePasswordModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    @csrf
                    <div class="form-group">
                        <label for="current_password">Senha Atual</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Nova Senha</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation">Confirmar Nova Senha</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btnSecondary" onclick="closeChangePasswordModal()">Cancelar</button>
                        <button type="submit" class="btnPrimary">Alterar Senha</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação para Excluir Conta -->
    <div id="deleteAccountModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Excluir Conta</h2>
                <span class="close" onclick="closeDeleteAccountModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="delete-account-warning">
                    <div class="warning-icon">⚠️</div>
                    <h3>Atenção!</h3>
                    <p>Esta ação é <strong>irreversível</strong>. Ao excluir sua conta:</p>
                    <ul>
                        <li>Todos os seus dados serão permanentemente removidos</li>
                        <li>Seus pedidos e histórico serão perdidos</li>
                        <li>Não será possível recuperar a conta</li>
                        <li>Você será deslogado automaticamente</li>
                    </ul>
                    <p><strong>Tem certeza que deseja continuar?</strong></p>
                </div>
                <form id="deleteAccountForm">
                    @csrf
                    <div class="form-group">
                        <label for="delete_password">Digite sua senha para confirmar</label>
                        <input type="password" id="delete_password" name="password" required>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btnSecondary" onclick="closeDeleteAccountModal()">Cancelar</button>
                        <button type="submit" class="btnDanger">Excluir Conta Permanentemente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 0;
            border-radius: 8px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #e0e0e0;
        }

        .modal-header h2 {
            margin: 0;
            color: #333;
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .modal-body {
            padding: 20px;
        }

        .order-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .order-info h3 {
            margin-top: 0;
            color: #333;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-weight: bold;
            color: #666;
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .info-value {
            color: #333;
            font-size: 1.1em;
        }

        .order-items {
            margin-top: 20px;
        }

        .order-items h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .item-card {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 10px;
            background: white;
        }

        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 15px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .item-info {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 3px;
        }

        .item-price {
            font-weight: bold;
            color: #28a745;
            margin-top: 5px;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #666;
        }

        .error {
            text-align: center;
            padding: 40px;
            color: #dc3545;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .order-payments {
            margin-top: 20px;
        }

        .order-payments h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .payment-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            border: 1px solid #e0e0e0;
        }

        .payment-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }

        .payment-method {
            font-weight: bold;
            color: #333;
        }

        .payment-amount {
            color: #28a745;
            font-weight: bold;
        }

        .payment-date {
            color: #666;
            font-size: 0.9em;
        }

        @media (max-width: 768px) {
            .payment-info {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /* Estilos para o modal de mudança de senha */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .form-actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .form-actions .btnPrimary {
            background-color: #ff6b35;
            color: white;
        }

        .form-actions .btnPrimary:hover {
            background-color: #e55a2b;
        }

        .form-actions .btnSecondary {
            background-color: #6c757d;
            color: white;
        }

        .form-actions .btnSecondary:hover {
            background-color: #545b62;
        }

        .form-actions .btnDanger {
            background-color: #dc3545;
            color: white;
        }

        .form-actions .btnDanger:hover {
            background-color: #c82333;
        }

        /* Estilos para o modal de exclusão de conta */
        .delete-account-warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .warning-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .delete-account-warning h3 {
            color: #856404;
            margin-bottom: 15px;
            font-size: 18px;
        }

        .delete-account-warning p {
            color: #856404;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .delete-account-warning ul {
            text-align: left;
            margin: 15px 0;
            padding-left: 20px;
        }

        .delete-account-warning li {
            color: #856404;
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .delete-account-warning strong {
            color: #721c24;
        }


        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #f3f3f3;
            border-top: 2px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Sistema de Toast */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        }

        .toast {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-bottom: 10px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
            border-left: 4px solid;
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast.success {
            border-left-color: #28a745;
        }

        .toast.error {
            border-left-color: #dc3545;
        }

        .toast-icon {
            margin-right: 12px;
            font-size: 20px;
        }

        .toast.success .toast-icon {
            color: #28a745;
        }

        .toast.error .toast-icon {
            color: #dc3545;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: bold;
            margin-bottom: 4px;
            font-size: 14px;
        }

        .toast-message {
            font-size: 13px;
            color: #666;
        }

        .toast-close {
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            font-size: 18px;
            margin-left: 10px;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toast-close:hover {
            color: #666;
        }

        @media (max-width: 768px) {
            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }

        /* Mobile Layout - Minha Conta */
        @media (max-width: 768px) {
            .alignSection {
                padding: 10px;
            }

            .container {
                display: flex;
                flex-direction: column;
                gap: 0;
                padding: 0;
            }

            .sidebar {
                width: 100%;
                margin-bottom: 15px;
                order: -1;
            }

            .sidebar ul {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                padding: 0;
                margin: 0;
                list-style: none;
            }

            .sidebar li {
                flex: 1;
                min-width: 100px;
            }

            .sidebar a {
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 8px 4px;
                font-size: 0.75em;
                text-align: center;
                gap: 4px;
                border-radius: 6px;
                transition: all 0.3s;
            }

            .sidebar a img {
                width: 18px;
                height: 18px;
            }

            .mainContent {
                width: 100%;
                padding: 0;
            }

            .userGreeting {
                padding: 15px;
                margin-bottom: 15px;
            }

            .userGreeting .group {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .userGreeting h2 {
                font-size: 1.5em;
            }

            .userGreeting p {
                font-size: 0.9em;
            }

            .card {
                margin-bottom: 15px;
                padding: 15px;
                border-radius: 8px;
            }

            .cardAlign {
                display: flex;
                flex-direction: column;
                gap: 0;
            }

            /* Últimos Pedidos Mobile */
            .orders {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .orderCard {
                padding: 15px;
                border-radius: 8px;
            }

            .orderHeader {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .orderInfo {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                margin-bottom: 10px;
            }

            .orderInfo > div {
                background: #f8f9fa;
                padding: 8px;
                border-radius: 6px;
                border: 1px solid #e9ecef;
            }

            .orderInfo strong {
                font-size: 0.8em;
                display: block;
                margin-bottom: 3px;
                color: #666;
            }

            .orderActions {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .orderActions button {
                width: 100%;
                padding: 10px 16px;
                font-size: 0.9em;
                border-radius: 6px;
            }

            .deliveryDate {
                margin-top: 10px;
                padding: 8px 12px;
                font-size: 0.85em;
            }

            /* Endereços Mobile */
            .addressCards {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .addressCard {
                padding: 15px;
                border-radius: 8px;
                background: #f8f9fa;
                border: 1px solid #e9ecef;
            }

            .addressCard h3 {
                font-size: 1em;
                margin-bottom: 10px;
                color: #ff6b35;
            }

            .address {
                line-height: 1.4;
                font-size: 0.9em;
            }

            /* Meus Dados Mobile */
            .accessInfo {
                padding: 0;
            }

            .accessInfo h3 {
                font-size: 1.1em;
                margin-bottom: 15px;
                color: #333;
            }

            .infoRow {
                background: #f8f9fa;
                padding: 12px;
                border-radius: 6px;
                margin-bottom: 10px;
                border: 1px solid #e9ecef;
            }

            .infoRow .text {
                font-size: 0.95em;
                font-weight: 500;
            }

            .userActions {
                display: flex;
                flex-direction: column;
                gap: 8px;
                margin-top: 20px;
            }

            .userActions button {
                width: 100%;
                padding: 12px 16px;
                font-size: 0.9em;
                font-weight: 600;
                border-radius: 6px;
                border: none;
                cursor: pointer;
                transition: all 0.3s;
            }

            .edit {
                background-color: #ff6b35;
                color: white;
            }

            .edit:hover {
                background-color: #e55a2b;
            }

            .changePassword {
                background-color: #6c757d;
                color: white;
            }

            .changePassword:hover {
                background-color: #545b62;
            }

            .deleteAccount {
                background-color: #dc3545;
                color: white;
            }

            .deleteAccount:hover {
                background-color: #c82333;
            }

            /* Estados vazios */
            .no-orders,
            .no-addresses {
                padding: 30px 15px;
                text-align: center;
                color: #666;
            }

            .no-orders p,
            .no-addresses p {
                font-size: 0.9em;
                margin: 0;
            }
        }

        @media (max-width: 480px) {
            .alignSection {
                padding: 5px;
            }

            .sidebar ul {
                gap: 5px;
            }

            .sidebar li {
                min-width: 80px;
                flex: 1;
            }

            .sidebar a {
                padding: 6px 2px;
                font-size: 0.7em;
                gap: 2px;
            }

            .sidebar a img {
                width: 16px;
                height: 16px;
            }

            .card {
                padding: 12px;
                margin-bottom: 12px;
            }

            .userGreeting {
                padding: 12px;
            }

            .userGreeting h2 {
                font-size: 1.3em;
            }

            .orderInfo {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .orderInfo > div {
                padding: 6px;
            }

            .addressCard {
                padding: 12px;
            }

            .infoRow {
                padding: 10px;
            }

            .userActions button {
                padding: 10px 14px;
                font-size: 0.85em;
            }
        }
    </style>

    @push('scripts')
    <script src="{!! asset('assets/js/order-modal.js') !!}"></script>
    @endpush
@endsection
