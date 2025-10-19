@extends('layouts.app')
@section('title', 'Ellon Sports | Selecione o endereço de entrega')

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Toastify -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

@section('content')
<section class="checkoutSection">
    <div class="alignSection">
        <div class="checkout-container">
        <!-- Coluna da esquerda: Endereços e Frete -->
        <div class="checkout-main">
            <!-- Seção de Endereços -->
            <div class="addresses-section">
                <h2>Endereço de Entrega</h2>

                <!-- Botão Adicionar Novo Endereço -->
                <button type="button" class="add-address-btn" onclick="openAddressModal()">
                    <i class="fas fa-plus"></i> Adicionar Novo Endereço
                </button>

                <!-- Lista de Endereços -->
                <div class="addresses-list">
                    @foreach($addresses as $address)
                    <div class="address-card" data-address-id="{{ $address->id }}">
                        <div class="address-select">
                            <input type="radio"
                                   name="shipping_address"
                                   value="{{ $address->id }}"
                                   {{ $address->is_default ? 'checked' : '' }}>
                        </div>
                        <div class="address-info">
                            <p class="address-line">
                                {{ $address->street }}, {{ $address->number }}
                                @if($address->complement)
                                    - {{ $address->complement }}
                                @endif
                            </p>
                            <p class="address-line">{{ $address->neighborhood }}</p>
                            <p class="address-line">
                                {{ $address->city }} - {{ $address->state }}
                            </p>
                            <p class="address-line">CEP: {{ $address->zip_code }}</p>
                        </div>
                        <div class="address-actions">
                            <button type="button" class="btn-edit" data-address-id="{{ $address->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn-delete" data-address-id="{{ $address->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

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

            <!-- Seção de Métodos de Envio -->
            <div class="shipping-methods-section">
                <h2>Método de Envio</h2>
                <div class="shipping-methods-list">
                    <div class="loading-shipping">
                        Selecione um endereço para calcular o frete
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna da direita: Resumo do Pedido -->
        <div class="order-summary">
            <h2>Resumo do Pedido</h2>

            <!-- Valores -->
            <div class="order-totals">
                <div class="total-line">
                    <span>Total</span>
                    <span>R$ {{ number_format($cart->total, 2, ',', '.') }}</span>
                </div>
                @if($cart->discount > 0)
                <div class="total-line discount">
                    <span>Desconto</span>
                    <span>-R$ {{ number_format($cart->discount, 2, ',', '.') }}</span>
                </div>
                @endif
                <div class="total-line shipping">
                    <span>Frete</span>
                    <span id="shipping-cost">R$ {{ number_format($cart->shipping, 2, ',', '.') }}</span>
                </div>
                <div class="total-line grand-total">
                    <span>Subtotal</span>
                    <span>R$ {{ number_format($cart->subTotal, 2, ',', '.') }}</span>
                </div>
            </div>

            <!-- Cupom de Desconto -->
            <div class="coupon-section">
{{--                <input type="text" --}}
{{--                       id="coupon-code" --}}
{{--                       placeholder="Digite seu cupom"--}}
{{--                       class="form-control">--}}
{{--                <button class="btn-apply-coupon">Aplicar</button>--}}
            </div>

            <!-- Botão de Finalizar -->
            <button class="btn-complete-order" disabled>
                Continuar para o Pagamento
            </button>
        </div>
    </div>
    </div>
</section>

<!-- Loading State Component -->
<div id="loading-overlay" class="loading-overlay" style="display: none;">
    <div class="loading-spinner"></div>
    <p>Processando...</p>
</div>

<!-- Error Toast Component -->
<div id="error-toast" class="error-toast" style="display: none;">
    <div class="error-content">
        <i class="fas fa-exclamation-circle"></i>
        <span id="error-message"></span>
    </div>
</div>

<style>
.checkoutSection {
    margin: 0 auto;
    max-width: 1400px;
    min-height: calc(100vh - 162px);
    width: 100%;
}

.checkout-container {
    display: flex;
    gap: 30px;
    padding: 20px 0;
}

.checkout-main {
    flex: 1;
}

.order-summary {
    width: 350px;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Seção de Endereços */
.addresses-section {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.add-address-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #FF7F00;
    color: white;
    border-radius: 4px;
    text-decoration: none;
    margin-bottom: 20px;
}

.add-address-btn:hover {
    background: #e67300;
    color: white;
    text-decoration: none;
}

.addresses-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.address-card {
    display: flex;
    gap: 15px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    align-items: flex-start;
}

.address-card:hover {
    border-color: #FF7F00;
}

.address-info {
    flex: 1;
}

.address-line {
    margin: 0;
    line-height: 1.4;
}

.address-actions {
    display: flex;
    gap: 8px;
    align-items: flex-start;
}

.btn-edit,
.btn-delete {
    background: none;
    border: none;
    padding: 8px;
    cursor: pointer;
    transition: color 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
}

.btn-edit {
    color: #0056b3;
}

.btn-edit:hover {
    background-color: rgba(0, 86, 179, 0.1);
}

.btn-delete {
    color: #dc3545;
}

.btn-delete:hover {
    background-color: rgba(220, 53, 69, 0.1);
}

/* Seção de Métodos de Envio */
.shipping-methods-section {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.shipping-method {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 10px;
    cursor: pointer;
}

.shipping-method:hover {
    border-color: #FF7F00;
}

.shipping-method-info {
    flex: 1;
}

.shipping-method-price {
    font-weight: bold;
}

/* Resumo do Pedido */
.cart-items {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #ddd;
}

.cart-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.item-info {
    display: flex;
    align-items: center;
    gap: 15px;
    flex: 1;
}

.item-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.item-details {
    display: flex;
    flex-direction: column;
}

.item-name {
    font-weight: 500;
    margin-bottom: 4px;
}

.item-size {
    font-size: 0.9em;
    color: #666;
}

.item-price-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.item-quantity {
    font-size: 0.9em;
    color: #666;
}

.item-price {
    font-weight: 500;
}

.order-totals {
    margin-bottom: 20px;
}

.total-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.discount span:last-child{
    color: #a40000;
}

.grand-total {
    font-size: 1.2em;
    font-weight: bold;
    padding-top: 10px;
    border-top: 2px solid #ddd;
}

.coupon-section {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.btn-apply-coupon {
    padding: 8px 15px;
    background: #FF7F00;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-apply-coupon:hover {
    background: #e67300;
}

.btn-complete-order {
    width: 100%;
    padding: 15px;
    background: #FF7F00;
    color: white;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    cursor: pointer;
}

.btn-complete-order:hover {
    background: #e67300;
}

.btn-complete-order:disabled {
    background: #cccccc;
    cursor: not-allowed;
}

.btn-complete-order:not(:disabled):hover {
    background: #e67300;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.btn-complete-order:not(:disabled):active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.loading-shipping {
    text-align: center;
    padding: 20px;
    color: #666;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    z-index: 99999;
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
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    color: #666;
}

.modal-body {
    padding: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-row {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
}

.col-4 {
    flex: 0 0 33.333333%;
}

.col-8 {
    flex: 0 0 66.666667%;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.form-control:focus {
    border-color: #FF7F00;
    outline: none;
}

.form-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 20px;
}

.btn-save {
    background: #FF7F00;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-save:hover {
    background: #e67300;
}

.btn-cancel {
    background: #eee;
    color: #666;
    border: none;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-cancel:hover {
    background: #ddd;
}

.add-address-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #FF7F00;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 20px;
    font-size: 1rem;
}

.add-address-btn:hover {
    background: #e67300;
}

/* Estilo para os toasts */
.toastify {
    padding: 12px 20px;
    color: #fff;
    border-radius: 4px;
    font-size: 14px;
}

.toastify.success {
    background: #28a745;
}

.toastify.error {
    background: #dc3545;
}

/* Loading Overlay */
.loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 5px solid #f3f3f3;
    border-top: 5px solid #FF7F00;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Error Toast */
.error-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #ff4444;
    color: white;
    padding: 15px 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 10000;
    display: none;
    animation: slideIn 0.3s ease-out;
}

.error-content {
    display: flex;
    align-items: center;
    gap: 10px;
}

@keyframes slideIn {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

/* ===========================================
   RESPONSIVE DESIGN - MOBILE FIRST
   =========================================== */

/* Tablet and below */
@media (max-width: 1024px) {
    .checkout-container {
        flex-direction: column;
        gap: 20px;
    }
    
    .order-summary {
        width: 100%;
        order: -1; /* Move summary to top on mobile */
    }
    
    .checkout-main {
        order: 1;
    }
}

/* Mobile landscape and below */
@media (max-width: 768px) {
    .checkoutSection {
        min-height: calc(100vh - 120px);
    }
    
    .checkout-container {
        padding: 10px 0;
        gap: 15px;
    }
    
    .addresses-section,
    .shipping-methods-section,
    .order-summary {
        padding: 15px;
        margin-bottom: 15px;
    }
    
    .address-card {
        flex-direction: column;
        gap: 10px;
        padding: 12px;
    }
    
    .address-actions {
        justify-content: flex-end;
        margin-top: 10px;
    }
    
    .btn-edit,
    .btn-delete {
        padding: 10px;
        min-width: 44px;
        min-height: 44px;
    }
    
    .add-address-btn {
        width: 100%;
        justify-content: center;
        padding: 15px 20px;
        font-size: 16px;
    }
    
    .shipping-method {
        padding: 12px;
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
    
    .shipping-method-info {
        order: 1;
    }
    
    .shipping-method-price {
        order: 2;
        font-size: 18px;
        font-weight: bold;
    }
    
    .order-summary h2 {
        font-size: 20px;
        margin-bottom: 15px;
    }
    
    .btn-complete-order {
        padding: 18px;
        font-size: 16px;
        min-height: 56px;
    }
    
    /* Modal improvements for mobile */
    .modal-content {
        width: 95%;
        margin: 20px auto;
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .modal-body {
        padding: 15px;
    }
    
    .form-row {
        flex-direction: column;
        gap: 0;
    }
    
    .col-4,
    .col-8 {
        flex: 1;
        width: 100%;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-save,
    .btn-cancel {
        width: 100%;
        padding: 15px;
        font-size: 16px;
    }
}

/* Small mobile devices */
@media (max-width: 480px) {
    .checkoutSection {
        min-height: calc(100vh - 100px);
    }
    
    .addresses-section h2,
    .shipping-methods-section h2,
    .order-summary h2 {
        font-size: 18px;
        margin-bottom: 12px;
    }
    
    .address-card {
        padding: 10px;
    }
    
    .address-line {
        font-size: 14px;
        line-height: 1.3;
    }
    
    .shipping-method {
        padding: 10px;
    }
    
    .shipping-method-info {
        font-size: 14px;
    }
    
    .shipping-method-price {
        font-size: 16px;
    }
    
    .order-totals {
        font-size: 14px;
    }
    
    .grand-total {
        font-size: 16px;
    }
    
    .btn-complete-order {
        padding: 16px;
        font-size: 15px;
        min-height: 52px;
    }
    
    .modal-content {
        width: 98%;
        margin: 10px auto;
    }
    
    .modal-header {
        padding: 12px 15px;
    }
    
    .modal-header h3 {
        font-size: 18px;
    }
    
    .form-control {
        padding: 12px;
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .form-group {
        margin-bottom: 12px;
    }
}

/* Touch improvements */
@media (hover: none) and (pointer: coarse) {
    .address-card:hover {
        border-color: #ddd;
    }
    
    .address-card:active {
        border-color: #FF7F00;
        background-color: #fff8f0;
    }
    
    .shipping-method:hover {
        border-color: #ddd;
    }
    
    .shipping-method:active {
        border-color: #FF7F00;
        background-color: #fff8f0;
    }
    
    .btn-edit:hover,
    .btn-delete:hover {
        background-color: transparent;
    }
    
    .btn-edit:active {
        background-color: rgba(0, 86, 179, 0.1);
    }
    
    .btn-delete:active {
        background-color: rgba(220, 53, 69, 0.1);
    }
}

/* Landscape orientation adjustments */
@media (max-width: 768px) and (orientation: landscape) {
    .checkout-container {
        flex-direction: row;
        gap: 15px;
    }
    
    .checkout-main {
        flex: 2;
    }
    
    .order-summary {
        flex: 1;
        order: 1;
    }
}

/* High DPI displays */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .address-card,
    .shipping-method,
    .order-summary {
        border-width: 0.5px;
    }
}
</style>

<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addressRadios = document.querySelectorAll('input[name="shipping_address"]');
    const shippingMethodsList = document.querySelector('.shipping-methods-list');
    const btnCompleteOrder = document.querySelector('.btn-complete-order');
    let selectedShippingMethod = null;

    // Valores iniciais do carrinho
    const initialValues = {
        subtotal: parseFloat("{{ $cart->subTotal }}"),
        discount: parseFloat("{{ $cart->discount }}"),
        shipping: parseFloat("{{ $cart->shipping }}")
    };

    // Função para formatar preço
    function formatPrice(value) {
        return `R$ ${value.toFixed(2).replace('.', ',')}`;
    }

    // Função para calcular e atualizar totais
    function updateTotals(shippingPrice) {
        const total = initialValues.subtotal - initialValues.discount + shippingPrice;

        document.getElementById('shipping-cost').textContent = formatPrice(shippingPrice);
        document.querySelector('.grand-total span:last-child').textContent = formatPrice(total);
    }

    // Função para calcular frete quando um endereço é selecionado
    async function calculateShipping(addressId) {
        showLoading();
        shippingMethodsList.innerHTML = '<div class="loading-shipping">Calculando frete...</div>';

        try {
            const response = await fetch('/checkout/calculate-shipping/' + addressId, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            });

            const shippingOptions = await response.json();

            if (!shippingOptions.length) {
                shippingMethodsList.innerHTML = '<div class="loading-shipping">Não foi possível calcular o frete para este endereço.</div>';
                return;
            }

            shippingMethodsList.innerHTML = shippingOptions.map(option => `
                <div class="shipping-method"
                     data-price="${option.price}"
                     data-days="${option.days}"
                     data-company="${option.company}">
                    <input type="radio" name="shipping_method" value="${option.name}">
                    <div class="shipping-method-info">
                        <div>${option.company} - ${option.name}</div>
                        <div>Prazo de entrega: ${option.days}</div>
                    </div>
                    <div class="shipping-method-price">
                        R$ ${(option.price).toFixed(2).replace('.', ',')}
                    </div>
                </div>
            `).join('');

            // Adiciona listeners para os métodos de envio
            document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
                radio.addEventListener('change', function(e) {
                    const shippingMethod = e.target.closest('.shipping-method');
                    const shippingPrice = parseFloat(shippingMethod.dataset.price);

                    updateTotals(shippingPrice);
                    selectedShippingMethod = e.target.value;
                    btnCompleteOrder.disabled = false;
                });
            });

            // Seleciona automaticamente o primeiro método de envio
            const firstShippingMethod = document.querySelector('input[name="shipping_method"]');
            if (firstShippingMethod) {
                firstShippingMethod.checked = true;
                const shippingMethod = firstShippingMethod.closest('.shipping-method');
                const shippingPrice = parseFloat(shippingMethod.dataset.price);
                
                updateTotals(shippingPrice);
                selectedShippingMethod = firstShippingMethod.value;
                btnCompleteOrder.disabled = false;
            }

        } catch (error) {
            showError(error.message);
            shippingMethodsList.innerHTML = '<div class="loading-shipping">Erro ao calcular frete. Tente novamente.</div>';
        } finally {
            hideLoading();
        }
    }

    // Adiciona listeners para os endereços
    addressRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            calculateShipping(e.target.value);
            btnCompleteOrder.disabled = true;
            selectedShippingMethod = null;
        });

        // Se o endereço já estiver selecionado, calcula o frete
        if (radio.checked) {
            calculateShipping(radio.value);
        }
    });

    // Máscaras de input
    const zipcodeMask = IMask(document.getElementById('zip_code'), {
        mask: '00000-000'
    });

    // Função para abrir modal de endereço
    window.openAddressModal = function(addressId = null) {
        const modal = document.getElementById('addressModal');
        const form = document.getElementById('addressForm');
        const modalTitle = document.getElementById('modalTitle');

        // Limpa o formulário
        form.reset();
        document.getElementById('addressId').value = '';

        if (addressId) {
            modalTitle.textContent = 'Editar Endereço';
            loadAddress(addressId);
        } else {
            modalTitle.textContent = 'Novo Endereço';
        }

        modal.style.display = 'block';
        
        // Mobile-specific improvements
        if (isMobile()) {
            // Prevent body scroll when modal is open
            document.body.style.overflow = 'hidden';
            
            // Focus first input after modal opens
            setTimeout(() => {
                const firstInput = modal.querySelector('input');
                if (firstInput) {
                    firstInput.focus();
                }
            }, 100);
        }
    }

    // Função para fechar modal de endereço
    window.closeAddressModal = function() {
        document.getElementById('addressModal').style.display = 'none';
        
        // Restore body scroll on mobile
        if (isMobile()) {
            document.body.style.overflow = '';
        }
    }

    // Função para carregar dados do endereço
    async function loadAddress(addressId) {
        try {
            const response = await fetch(`/api/addresses/${addressId}`);
            const address = await response.json();

            document.getElementById('addressId').value = address.id;
            document.getElementById('zip_code').value = address.zip_code;
            document.getElementById('street').value = address.street;
            document.getElementById('number').value = address.number;
            document.getElementById('complement').value = address.complement || '';
            document.getElementById('neighborhood').value = address.neighborhood;
            document.getElementById('city').value = address.city;
            document.getElementById('state').value = address.state;
        } catch (error) {
            console.error('Erro ao carregar endereço:', error);
            showToast('Erro ao carregar endereço', true);
        }
    }

    // Função para confirmar exclusão
    window.confirmDeleteAddress = function(addressId) {
        const modal = document.getElementById('confirmModal');
        const btnConfirm = document.getElementById('confirmDelete');

        modal.style.display = 'block';

        // Remove listener anterior se existir
        btnConfirm.replaceWith(btnConfirm.cloneNode(true));

        // Adiciona novo listener
        document.getElementById('confirmDelete').addEventListener('click', async () => {
            await deleteAddress(addressId);
            closeConfirmModal();
        });
    }

    // Função para fechar modal de confirmação
    window.closeConfirmModal = function() {
        document.getElementById('confirmModal').style.display = 'none';
    }

    // Função para deletar endereço
    async function deleteAddress(addressId) {
        try {
            const response = await fetch(`/api/addresses/${addressId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
            });

            const data = await response.json();

            if (data.success) {
                const addressCard = document.querySelector(`.address-card[data-address-id="${addressId}"]`);
                addressCard.remove();
                closeConfirmModal();
                showToast('Endereço removido com sucesso');
            } else {
                showToast(data.message || 'Erro ao remover endereço', true);
            }
        } catch (error) {
            console.error('Erro ao deletar endereço:', error);
            showToast('Erro ao remover endereço', true);
        }
    }

    // Manipulador do formulário de endereço
    document.getElementById('addressForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const addressId = formData.get('id');
        const method = addressId ? 'PUT' : 'POST';
        const url = addressId ? `/api/addresses/${addressId}` : '/api/addresses';

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(Object.fromEntries(formData)),
            });

            const data = await response.json();

            if (data.success) {
                closeAddressModal();
                showToast(addressId ? 'Endereço atualizado com sucesso' : 'Endereço cadastrado com sucesso');
                // Recarrega a página para atualizar a lista de endereços
                window.location.reload();
            } else {
                if (data.errors) {
                    // Mostra todos os erros de validação
                    Object.values(data.errors).forEach(error => {
                        showToast(error[0], true);
                    });
                } else {
                    showToast(data.message || 'Erro ao salvar endereço', true);
                }
            }
        } catch (error) {
            console.error('Erro ao salvar endereço:', error);
            showToast('Erro ao salvar endereço', true);
        }
    });

    // Auto preenchimento do endereço pelo CEP
    document.getElementById('zip_code').addEventListener('blur', async function() {
        const cep = this.value.replace(/\D/g, '');

        if (cep.length !== 8) {
            showToast('CEP inválido', true);
            return;
        }

        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();

            if (data.erro) {
                showToast('CEP não encontrado', true);
                return;
            }

            document.getElementById('street').value = data.logradouro;
            document.getElementById('neighborhood').value = data.bairro;
            document.getElementById('city').value = data.localidade;
            document.getElementById('state').value = data.uf;

            // Foca no campo número se o logradouro foi preenchido
            if (data.logradouro) {
                document.getElementById('number').focus();
            }
        } catch (error) {
            console.error('Erro ao buscar CEP:', error);
            showToast('Erro ao buscar CEP', true);
        }
    });

    // Fecha os modais se clicar fora
    window.onclick = function(event) {
        const addressModal = document.getElementById('addressModal');
        const confirmModal = document.getElementById('confirmModal');

        if (event.target === addressModal) {
            closeAddressModal();
        }
        if (event.target === confirmModal) {
            closeConfirmModal();
        }
    }

    // Adiciona event listeners para os botões de editar e deletar
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const addressId = this.dataset.addressId;
            openAddressModal(addressId);
        });
    });

    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const addressId = this.dataset.addressId;
            confirmDeleteAddress(addressId);
        });
    });

    function showLoading() {
        document.getElementById('loading-overlay').style.display = 'flex';
    }

    function hideLoading() {
        document.getElementById('loading-overlay').style.display = 'none';
    }

    function showError(message) {
        const toast = document.getElementById('error-toast');
        document.getElementById('error-message').textContent = message;
        toast.style.display = 'block';
        setTimeout(() => {
            toast.style.display = 'none';
        }, 5000);
    }

    function updateContinueButton() {
        const addressSelected = document.querySelector('input[name="shipping_address"]:checked');
        const shippingSelected = document.querySelector('input[name="shipping_method"]:checked');
        const continueButton = document.querySelector('.btn-complete-order');

        continueButton.disabled = !(addressSelected && shippingSelected);
    }

    document.addEventListener('change', function(e) {
        if (e.target.name === 'shipping_method') {
            updateContinueButton();
        }
    });

    // Adiciona o evento de clique no botão de continuar
    document.querySelector('.btn-complete-order').addEventListener('click', async function() {
        const addressId = document.querySelector('input[name="shipping_address"]:checked').value;
        const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
        const shippingMethodContainer = shippingMethod.closest('.shipping-method');

        if (!addressId || !shippingMethod) {
            showToast('Selecione um endereço e método de envio', true);
            return;
        }

        showLoading();

        try {
            const response = await fetch('/checkout/save-shipping', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    address_id: addressId,
                    shipping_method: shippingMethod.value,
                    shipping_price: parseFloat(shippingMethodContainer.dataset.price),
                    shipping_days: parseInt(shippingMethodContainer.dataset.days),
                    shipping_company: shippingMethodContainer.dataset.company
                })
            });

            const data = await response.json();

            if (data.success) {
                window.location.href = '/checkout/payment';
            } else {
                showToast(data.message || 'Erro ao salvar informações de envio', true);
            }
        } catch (error) {
            console.error('Erro:', error);
            showToast('Erro ao processar sua solicitação', true);
        } finally {
            hideLoading();
        }
    });

    function showToast(message, isError = false) {
        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "right",
            backgroundColor: isError ? "#dc3545" : "#28a745",
        }).showToast();
    }

    // Mobile-specific improvements
    function isMobile() {
        return window.innerWidth <= 768;
    }

    // Improve touch interactions
    function addTouchSupport() {
        if (isMobile()) {
            // Add touch feedback for address cards
            document.querySelectorAll('.address-card').forEach(card => {
                card.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                    this.style.transition = 'transform 0.1s ease';
                });
                
                card.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Add touch feedback for shipping methods
            document.querySelectorAll('.shipping-method').forEach(method => {
                method.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                    this.style.transition = 'transform 0.1s ease';
                });
                
                method.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Improve button touch targets
            document.querySelectorAll('.btn-edit, .btn-delete').forEach(btn => {
                btn.style.minWidth = '44px';
                btn.style.minHeight = '44px';
            });
        }
    }

    // Initialize mobile improvements
    addTouchSupport();

    // Re-initialize on window resize
    window.addEventListener('resize', function() {
        setTimeout(addTouchSupport, 100);
    });

    // Prevent zoom on input focus (iOS)
    if (isMobile()) {
        document.querySelectorAll('input, select, textarea').forEach(input => {
            input.addEventListener('focus', function() {
                if (this.style.fontSize !== '16px') {
                    this.style.fontSize = '16px';
                }
            });
        });
    }
});
</script>
@endsection
