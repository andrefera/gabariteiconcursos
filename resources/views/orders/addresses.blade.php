@extends('layouts.app')
@section('title', 'Ellon Sports | Meus Endereços')
<link rel="stylesheet" href="{!! asset('assets/css/order_list.css') !!}">
@section('content')
    <div class="alignSection">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="#">Início</a></li>
                <li class="active">Meus Endereços</li>
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
                            <a href="{{ route('orders.index') }}">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-order.svg') }}"
                                     alt="Pedido">
                                Meus Pedidos
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('orders.addresses') }}" class="active">
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
                                <h2>Meus Endereços</h2>
                                <p>Gerencie seus endereços de entrega e cobrança</p>
                            </div>
                        </div>
                    </header>

                    <section class="card">
                        <div class="titleGroup">
                            <div class="subGroup">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-address.svg') }}"
                                     alt="Endereços">
                                <h2>Endereços Cadastrados</h2>
                            </div>
                            <div class="actionGroup">
                                <button class="btnPrimary add-address-btn">
                                    Novo Endereço
                                </button>
                            </div>
                        </div>

                        <div class="address-section">
                            <div class="addressCards" id="addressCardsContainer">
                            @if(count($addresses) > 0)
                                @foreach($addresses as $address)
                                    <div class="addressCard {{ $address['is_default'] ?? false ? 'default-address' : '' }}">
                                        <div class="addressHeader">
                                            <div class="titleGroup">
                                                @if($address['is_default'] ?? false)
                                                    <span class="default-badge">Padrão</span>
                                                @endif
                                            </div>
                                            <div class="addressActions">
                                                <button class="btnSecondary btn-sm edit-address-btn" data-address-id="{{ $address['id'] }}">Editar</button>
                                                <button class="btnDanger btn-sm delete-address-btn" data-address-id="{{ $address['id'] }}">Excluir</button>
                                            </div>
                                        </div>
                                        <div class="address">
                                            <strong>{{ $address['name'] }}</strong><br>
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
                                    <div class="empty-state">
                                        <img width="64" height="64" src="{{ asset('images/icons/location.svg') }}" alt="Sem endereços">
                                        <h3>Nenhum endereço cadastrado</h3>
                                        <p>Adicione um endereço para facilitar suas compras</p>
                                        <button class="btnPrimary add-address-btn">
                                            <img width="16" height="16" src="{{ asset('images/icons/plus.svg') }}" alt="Adicionar">
                                            Adicionar
                                        </button>
                                    </div>
                                </div>
                            @endif
                            </div>
                            <div class="scroll-indicator" id="scrollIndicator">
                                Role para ver mais
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </div>
    </main>

    <!-- Modal de Endereço -->
    <div id="addressModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Novo Endereço</h3>
                <button type="button" class="close-modal" onclick="closeAddressModal()">&times;</button>
            </div>
            <form id="addressForm" class="modal-body">
                @csrf
                <input type="hidden" id="addressId" name="id">

                <div class="form-group">
                    <label for="zip_code">CEP</label>
                    <input type="text" id="zip_code" name="zip_code" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="street">Rua</label>
                    <input type="text" id="street" name="street" class="form-control" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-4">
                        <label for="number">Número</label>
                        <input type="text" id="number" name="number" class="form-control" required>
                    </div>
                    <div class="form-group col-8">
                        <label for="complement">Complemento</label>
                        <input type="text" id="complement" name="complement" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="neighborhood">Bairro</label>
                    <input type="text" id="neighborhood" name="neighborhood" class="form-control" required>
                </div>

                <div class="form-row">
                    <div class="form-group col-8">
                        <label for="city">Cidade</label>
                        <input type="text" id="city" name="city" class="form-control" required>
                    </div>
                    <div class="form-group col-4">
                        <label for="state">Estado</label>
                        <select id="state" name="state" class="form-control" required>
                            <option value="">Selecione</option>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="is_default" name="is_default" class="checkbox-input">
                        <span class="checkbox-custom"></span>
                        <span class="checkbox-text">Definir como endereço padrão</span>
                    </label>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">Salvar Endereço</button>
                    <button type="button" class="btn-cancel" onclick="closeAddressModal()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div id="confirmModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirmar Exclusão</h3>
                <button type="button" class="close-modal" onclick="closeConfirmModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir este endereço?</p>
                <div class="form-actions">
                    <button type="button" class="btn-delete" id="confirmDelete">Sim, Excluir</button>
                    <button type="button" class="btn-cancel" onclick="closeConfirmModal()">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Container de Toast -->
    <div id="toastContainer" class="toast-container"></div>

    <style>
        .titleGroup {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .actionGroup .btnPrimary {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #ff6b35;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.3s;
        }

        .actionGroup .btnPrimary:hover {
            background-color: #e55a2b;
            transform: translateY(-1px);
        }

         .addressCards {
             display: grid;
             grid-template-columns: repeat(3, 1fr);
             gap: 20px;
             max-height: 500px;
             overflow-y: auto;
             padding-right: 8px;
             width: 100%;
         }

         /* Responsivo - reduz colunas em telas menores */
         @media (max-width: 1400px) {
             .addressCards {
                 grid-template-columns: repeat(2, 1fr);
             }
         }

         @media (max-width: 1000px) {
             .addressCards {
                 grid-template-columns: repeat(1, 1fr);
             }
         }

         @media (max-width: 767px) {
             .addressCards {
                 grid-template-columns: 1fr !important;
                 max-height: 400px;
             }
         }

        /* Scrollbar customizada */
        .addressCards::-webkit-scrollbar {
            width: 6px;
        }

        .addressCards::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .addressCards::-webkit-scrollbar-thumb {
            background: #ff6b35;
            border-radius: 3px;
        }

        .addressCards::-webkit-scrollbar-thumb:hover {
            background: #e55a2b;
        }

        /* Indicador de scroll */
        .address-section {
            position: relative;
        }

        .scroll-indicator {
            position: absolute;
            bottom: 10px;
            right: 20px;
            background: rgba(255, 107, 53, 0.9);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s ease;
            pointer-events: none;
            z-index: 10;
        }

        .scroll-indicator.show {
            opacity: 1;
            transform: translateY(0);
        }

        .scroll-indicator::before {
            content: '↓';
            margin-right: 5px;
            font-size: 1.1em;
        }

        .addressCard {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background: white;
            transition: all 0.3s;
        }

        .addressCard:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #ff6b35;
        }

        .addressCard.default-address {
            border-color: #ff6b35;
            background: linear-gradient(135deg, #fff9f5, #ffffff);
        }

        .addressHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .addressHeader .titleGroup {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .addressHeader h3 {
            margin: 0;
            color: #333;
            font-size: 1.1em;
        }

        .default-badge {
            background: linear-gradient(135deg, #ff6b35, #e55a2b);
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.75em;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(255, 107, 53, 0.3);
        }

        .addressActions {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8em;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btnSecondary {
            background-color: #6c757d;
            color: white;
        }

        .btnSecondary:hover {
            background-color: #545b62;
        }

        .btnDanger {
            background-color: #dc3545;
            color: white;
        }

        .btnDanger:hover {
            background-color: #c82333;
        }

        .address {
            color: #666;
            line-height: 1.5;
        }

        .address strong {
            color: #333;
        }

        .phone {
            color: #ff6b35;
            font-weight: 600;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-state img {
            opacity: 0.5;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .empty-state p {
            margin-bottom: 30px;
            font-size: 0.9em;
        }

        .empty-state .btnPrimary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: #ff6b35;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s;
        }

        .empty-state .btnPrimary:hover {
            background-color: #e55a2b;
            transform: translateY(-1px);
        }

        /* Estilos do Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .modal-content {
            position: relative;
            background-color: #fff;
            margin: 50px auto;
            padding: 0;
            width: 90%;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-height: calc(100vh - 100px);
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            color: #333;
        }

        .close-modal {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            color: #666;
            transition: color 0.3s;
        }

        .close-modal:hover {
            color: #333;
        }

        .modal-body {
            padding: 20px;
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 0.9em;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        /* Checkbox customizado moderno */
        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-weight: 500;
            color: #333;
            font-size: 0.95em;
            margin-bottom: 0;
            padding: 12px 16px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .checkbox-label:hover {
            background: #fff5f0;
            border-color: #ff6b35;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.1);
        }

        .checkbox-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
            margin: 0;
        }

        .checkbox-custom {
            position: relative;
            width: 20px;
            height: 20px;
            border: 2px solid #ddd;
            border-radius: 6px;
            margin-right: 12px;
            transition: all 0.3s ease;
            background: white;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkbox-input:checked + .checkbox-custom {
            background: linear-gradient(135deg, #ff6b35, #e55a2b);
            border-color: #ff6b35;
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(255, 107, 53, 0.3);
        }

        .checkbox-input:checked + .checkbox-custom::after {
            content: '✓';
            color: white;
            font-size: 14px;
            font-weight: bold;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .checkbox-input:checked ~ .checkbox-text {
            color: #ff6b35;
            font-weight: 600;
        }

        .checkbox-label:hover .checkbox-custom {
            border-color: #ff6b35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }

        .checkbox-text {
            transition: color 0.3s ease;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .col-4 {
            flex: 0 0 30%;
        }

        .form-row .col-8 {
            flex: 0 0 70%;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .btn-save {
            background-color: #ff6b35;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-save:hover {
            background-color: #e55a2b;
            transform: translateY(-1px);
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background-color: #545b62;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-delete:hover {
            background-color: #c82333;
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
            }

            .titleGroup {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }

            .addressCards {
                grid-template-columns: 1fr !important;
                gap: 15px;
                padding-right: 4px;
                max-height: 400px;
            }

            .addressCards::-webkit-scrollbar {
                width: 4px;
            }

            .addressHeader {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .addressActions {
                align-self: stretch;
                justify-content: center;
            }

            .empty-state {
                padding: 40px 20px;
            }

            .modal {
                align-items: flex-start;
                padding: 10px;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .modal-content {
                margin: 20px auto;
                width: 95%;
                max-width: none;
                max-height: calc(100vh - 40px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
                position: relative;
            }

            .modal-body {
                padding: 15px;
                max-height: calc(100vh - 140px);
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .form-row .col-4,
            .form-row .col-8 {
                flex: none;
                margin-bottom: 15px;
            }

            .form-actions {
                flex-direction: column;
                gap: 8px;
            }

            .form-actions button {
                width: 100%;
                padding: 14px;
                font-size: 0.9em;
            }

            .checkbox-label {
                padding: 10px 12px;
                font-size: 0.9em;
            }

            .checkbox-custom {
                width: 18px;
                height: 18px;
                margin-right: 10px;
            }

            .checkbox-input:checked + .checkbox-custom::after {
                font-size: 12px;
            }

            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    </style>

    <!-- CDN para máscara de inputs -->
    <script src="https://unpkg.com/imask"></script>
    
    <!-- Script do modal de endereços -->
    <script src="{{ asset('assets/js/address-modal.js') }}"></script>

    <!-- Script de controle de scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addressContainer = document.getElementById('addressCardsContainer');
            const scrollIndicator = document.getElementById('scrollIndicator');
            
            if (addressContainer && scrollIndicator) {
                function checkScrollIndicator() {
                    const hasScrollbar = addressContainer.scrollHeight > addressContainer.clientHeight;
                    const isScrolledToBottom = addressContainer.scrollTop + addressContainer.clientHeight >= addressContainer.scrollHeight - 10;
                    
                    if (hasScrollbar && !isScrolledToBottom) {
                        scrollIndicator.classList.add('show');
                    } else {
                        scrollIndicator.classList.remove('show');
                    }
                }
                
                // Verifica inicialmente
                setTimeout(checkScrollIndicator, 100);
                
                // Verifica quando rola
                addressContainer.addEventListener('scroll', checkScrollIndicator);
                
                // Verifica quando a janela muda de tamanho
                window.addEventListener('resize', checkScrollIndicator);
                
                // Remove indicador após 3 segundos automaticamente
                setTimeout(() => {
                    scrollIndicator.classList.remove('show');
                }, 3000);
            }

            // Controle de scroll do modal no mobile
            function isMobile() {
                return window.innerWidth <= 768;
            }

            // Função para abrir modal (override da original se necessário)
            window.openAddressModalWithScrollFix = function(addressId = null) {
                const modal = document.getElementById('addressModal');
                if (modal) {
                    modal.style.display = 'block';
                    
                    // No mobile, evita scroll do body
                    if (isMobile()) {
                        document.body.style.overflow = 'hidden';
                        document.body.style.position = 'fixed';
                        document.body.style.width = '100%';
                        document.body.style.top = `-${window.scrollY}px`;
                    }
                }
                
                // Chama a função original se existir
                if (typeof openAddressModal === 'function') {
                    openAddressModal(addressId);
                }
            };

            // Função para fechar modal (override da original se necessário)
            window.closeAddressModalWithScrollFix = function() {
                const modal = document.getElementById('addressModal');
                if (modal) {
                    modal.style.display = 'none';
                    
                    // No mobile, restaura scroll do body
                    if (isMobile()) {
                        const scrollY = document.body.style.top;
                        document.body.style.position = '';
                        document.body.style.top = '';
                        document.body.style.overflow = '';
                        document.body.style.width = '';
                        
                        if (scrollY) {
                            window.scrollTo(0, parseInt(scrollY || '0') * -1);
                        }
                    }
                }
                
                // Chama a função original se existir
                if (typeof closeAddressModal === 'function') {
                    closeAddressModal();
                }
            };

            // Intercepta cliques nos botões para usar as novas funções
            document.addEventListener('click', function(e) {
                if (e.target.matches('.add-address-btn') && isMobile()) {
                    e.preventDefault();
                    e.stopPropagation();
                    openAddressModalWithScrollFix();
                }
                
                if (e.target.matches('.edit-address-btn') && isMobile()) {
                    e.preventDefault();
                    e.stopPropagation();
                    const addressId = e.target.getAttribute('data-address-id');
                    openAddressModalWithScrollFix(addressId);
                }

                if (e.target.matches('.close-modal, .btn-cancel') && isMobile()) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeAddressModalWithScrollFix();
                }
            });

            // Intercepta ESC key no mobile
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMobile()) {
                    const modal = document.getElementById('addressModal');
                    if (modal && modal.style.display === 'block') {
                        closeAddressModalWithScrollFix();
                    }
                }
            });
        });
    </script>

@endsection
