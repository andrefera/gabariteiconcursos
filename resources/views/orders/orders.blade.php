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
                        <a href="{{ route('profile.index') }}">
                            <img width="24" height="24" src="{{ asset('images/icons/mini-profile.svg') }}"
                                alt="Perfil">
                            Minha Conta
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders.index') }}" class="active">
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
                            <h1>Meus Pedidos</h1>
                            <p>Acompanhe todos os seus pedidos</p>
                        </div>
                    </div>
                </header>

                <div class="meusPedidos">
                    @if(count($orders) > 0)
                    @foreach($orders as $order)
                    <div class="card orderCard-detalhado">
                        <div class="orderHeader-detalhado">
                            <div class="orderInfo-detalhado">
                                <div>
                                    <strong>Número do Pedido</strong>
                                    <div>#{{ $order['order_number'] }}</div>
                                </div>
                                <div>
                                    <strong>Pagamento</strong>
                                    <div>{{ $order['payment_method'] }}</div>
                                </div>
                                <div>
                                    <strong>Data</strong>
                                    <div>{{ $order['created_at'] }}</div>
                                </div>
                                <div>
                                    <strong>Valor Total</strong>
                                    <div>{{ $order['total'] }}</div>
                                </div>
                                <div>
                                    <strong>Status:</strong>
                                    @if(in_array($order['status'], ['Entregue', 'Pago']))
                                    <span class="statusEntregue">{{ $order['status'] }}</span>
                                    @elseif(in_array($order['status'], ['Cancelado', 'Reembolsado']))
                                    <span class="statusPendente">{{ $order['status'] }}</span>
                                    @else
                                    <span class="statusPendente">{{ $order['status'] }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="orderActions-detalhado">
                                <button class="btnPrimary-green order-detail-btn" data-order-id="{{ $order['id'] }}">VER PEDIDO</button>
                                @if($order['tracking_number'])
                                <button class="btnSecondary-green">RASTREAR PEDIDO</button>
                                @endif
                                <button class="btnOutline-green">CONTATAR SUPORTE</button>
                            </div>
                        </div>
                        @if (count($order['progress_steps']) > 0)
                            <div class="orderProgress">
                                @foreach($order['progress_steps'] as $index => $step)
                                <div class="progressStep {{ $step['done'] ? 'done' : '' }}">
                                    <span class="icon">
                                        @if($step['done'])
                                        <i class="fas fa-check-circle"></i>
                                        @else
                                        <i class="fas fa-circle"></i>
                                        @endif
                                    </span>
                                    <div class="progressStep-content">
                                        <div class="stepLabel">{{ $step['label'] }}</div>
                                        @if($step['show_date'] && $step['date'])
                                        <div class="stepDate">{{ $step['date'] }}</div>
                                        @endif
                                    </div>
                                </div>
                                @if($index < count($order['progress_steps']) - 1)
                                    <div class="progressLine">
                            </div>
                        @endif
                        @endforeach
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
    </div>
    </div>
</main>

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

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
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

    .no-orders {
        text-align: center;
        padding: 40px;
        color: #666;
    }

    .no-orders p {
        font-size: 16px;
        margin: 0;
    }

    /* Base layout fixes */
    .container {
        display: flex;
        gap: 20px;
        max-width: 100%;
        width: 100%;
    }

    .sidebar {
        flex-shrink: 0;
        width: 250px;
    }

    .mainContent {
        flex: 1;
        min-width: 0;
    }

    .meusPedidos {
        width: 100%;
    }

    /* Prevent horizontal overflow */
    .alignSection {
        max-width: 100%;
        overflow-x: hidden;
    }

    * {
        box-sizing: border-box;
    }

    .orderCard-detalhado {
        margin-bottom: 25px;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        background: white;
        border: 1px solid #f0f0f0;
    }

    .orderHeader-detalhado {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f0f0f0;
    }

    .orderInfo-detalhado {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        flex: 1;
    }

    .orderInfo-detalhado>div {
        display: flex;
        flex-direction: column;
        min-width: 140px;
    }

    .orderInfo-detalhado strong {
        color: #666;
        font-size: 0.85em;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .orderInfo-detalhado div div {
        color: #333;
        font-weight: 600;
        font-size: 1em;
    }

    .orderInfo-detalhado>div:last-child {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .orderInfo-detalhado>div:last-child strong {
        text-align: center;
        margin-bottom: 8px;
    }

    .orderActions-detalhado {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btnPrimary-green {
        background-color: #ff6b35;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9em;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(255, 107, 53, 0.2);
    }

    .btnPrimary-green:hover {
        background-color: #e55a2b;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(255, 107, 53, 0.3);
    }

    .btnSecondary-green {
        background-color: #6c757d;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9em;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(108, 117, 125, 0.2);
    }

    .btnSecondary-green:hover {
        background-color: #545b62;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(108, 117, 125, 0.3);
    }

    .btnOutline-green {
        background-color: transparent;
        color: #ff6b35;
        border: 1px solid #ff6b35;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9em;
        transition: all 0.3s;
    }

    .btnOutline-green:hover {
        background-color: #ff6b35;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(255, 107, 53, 0.3);
    }

    .orderProgress {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        flex-wrap: wrap;
        gap: 0;
        margin-top: 15px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .progressStep {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        min-width: 120px;
        position: relative;
    }

    .progressStep .icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        color: #6c757d;
        font-size: 16px;
        border: 3px solid #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
    }

    .progressStep.done .icon {
        background-color: #28a745;
        color: white;
        box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
    }

    .progressStep .stepLabel {
        font-weight: 600;
        font-size: 0.85em;
        color: #333;
        margin-bottom: 4px;
        line-height: 1.2;
    }

    .progressStep .stepDate {
        font-size: 0.75em;
        color: #666;
        font-weight: 500;
        background: white;
        padding: 2px 6px;
        border-radius: 4px;
        border: 1px solid #e9ecef;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .progressStep-content {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .progressLine {
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #28a745 0%, #e9ecef 100%);
        margin: 0 -10px;
        position: relative;
        top: -20px;
        border-radius: 2px;
    }

    .statusEntregue {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8em;
        font-weight: 600;
        border: 1px solid #b8dabc;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .statusPendente {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
        color: #856404;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8em;
        font-weight: 600;
        border: 1px solid #f4d79b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .alignSection {
            padding: 10px;
        }

        .container {
            padding: 0;
            flex-direction: column;
            gap: 0;
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

        .orderCard-detalhado {
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
        }

        .orderHeader-detalhado {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
            padding-bottom: 10px;
        }

        .orderInfo-detalhado {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .orderInfo-detalhado>div {
            min-width: auto;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .orderInfo-detalhado>div:last-child {
            grid-column: 1 / -1;
            text-align: center;
            background: #fff;
            border: none;
            padding: 10px;
        }

        .orderInfo-detalhado strong {
            font-size: 0.8em;
            margin-bottom: 3px;
        }

        .orderInfo-detalhado div div {
            font-size: 0.9em;
        }

        .orderActions-detalhado {
            flex-direction: column;
            gap: 8px;
            margin-top: 10px;
        }

        .orderActions-detalhado button {
            width: 100%;
            padding: 10px 16px;
            font-size: 0.9em;
            font-weight: 600;
        }

        .orderProgress {
            flex-direction: column;
            gap: 15px;
            padding: 15px 10px;
            margin-top: 10px;
        }

        .progressStep {
            width: 100%;
            min-width: auto;
            flex-direction: row;
            text-align: left;
            justify-content: flex-start;
            gap: 15px;
            padding: 12px;
            background: white;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .progressStep .icon {
            width: 32px;
            height: 32px;
            font-size: 14px;
            margin-bottom: 0;
            flex-shrink: 0;
        }

        .progressStep-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .progressStep .stepLabel {
            font-size: 0.9em;
            margin-bottom: 0;
            font-weight: 600;
            color: #333;
        }

        .progressStep .stepDate {
            font-size: 0.75em;
            background: transparent;
            border: none;
            padding: 0;
            color: #666;
            font-weight: 500;
            margin-top: 2px;
        }

        .progressLine {
            display: none;
        }

        .statusEntregue,
        .statusPendente {
            padding: 4px 10px;
            font-size: 0.75em;
            display: inline-block;
            margin-top: 5px;
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

        .orderCard-detalhado {
            padding: 12px;
            margin-bottom: 12px;
        }

        .orderInfo-detalhado {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .orderInfo-detalhado>div {
            padding: 6px;
        }

        .orderInfo-detalhado strong {
            font-size: 0.75em;
        }

        .orderInfo-detalhado div div {
            font-size: 0.85em;
        }

        .orderActions-detalhado button {
            padding: 8px 14px;
            font-size: 0.85em;
        }

        .orderProgress {
            padding: 10px 5px;
            gap: 10px;
        }

        .progressStep {
            padding: 10px;
            gap: 12px;
        }

        .progressStep .icon {
            width: 28px;
            height: 28px;
            font-size: 12px;
        }

        .progressStep-content {
            gap: 1px;
        }

        .progressStep .stepLabel {
            font-size: 0.85em;
            line-height: 1.2;
        }

        .progressStep .stepDate {
            font-size: 0.7em;
            line-height: 1.2;
            margin-top: 1px;
        }

        .userGreeting h1 {
            font-size: 1.5em;
        }

        .userGreeting p {
            font-size: 0.9em;
        }
    }
</style>

@push('scripts')
<script src="{!! asset('assets/js/order-modal.js') !!}"></script>
@endpush
@endsection