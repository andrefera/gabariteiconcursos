@extends('layouts.app')
@section('title', 'Ellon Sports | Pagamento')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Toastify -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

@section('content')
<section class="paymentSection">
    <div class="alignSection">
        <div class="payment-container">
            <div class="payment-main">
                <div class="order-summary-card">
                    <h2><i class="fas fa-shopping-bag"></i> Resumo do Pedido <span class="item-count">({{$cart->totalProducts}} itens)</span></h2>
                    <div class="products-list">
                        @foreach($cart->products as $product)
                        <div class="product-item">
                            <div class="product-image">
                                <img src="{{$product->imageUrl ?? ''}}" alt="{{$product->name}}">
                            </div>
                            <div class="product-details">
                                <h4>{{$product->name}}</h4>
                                <div class="product-meta">
                                    <span class="size">Tamanho: <strong>{{$product->size}}</strong></span>
                                    <span class="quantity">Qtd: {{$product->quantity}}</span>
                                </div>
                            </div>
                            <div class="product-price">
                                <strong>{{$product->priceLabel}}</strong>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="order-totals">
                        <div class="total-line">
                            <span>Subtotal</span>
                            <span>{{\App\Support\Util\NumberUtil::formatPrice($cart->subTotal)}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="payment-form-card">
                <h2><i class="fas fa-credit-card"></i> Pagamento</h2>
                
                <form id="paymentForm" class="payment-form">
                    <div class="payment-method-selector">
                        <button type="button" class="payment-method-btn active" data-method="credit_card">
                            <i class="fas fa-credit-card"></i>
                            <span>Cartão de Crédito</span>
                        </button>
                        <button type="button" class="payment-method-btn" data-method="pix">
                            <i class="fas fa-qrcode"></i>
                            <span>PIX</span>
                        </button>
                        <button type="button" class="payment-method-btn" data-method="ticket">
                            <i class="fas fa-barcode"></i>
                            <span>Boleto</span>
                        </button>
                    </div>

                    <input id="paymentMethod" type="hidden" value="credit_card">
                    
                    <div class="payment-fields" id="card-fields">
                        <div class="card-number-section">
                            <label for="cardNumber">Número do Cartão</label>
                            <div class="card-input-group">
                                <input type="text" id="cardNumber" placeholder="0000 0000 0000 0000" data-msg="Digite um número de cartão válido">
                                <div class="card-icons" id="card-icons">
                                    <img src="{{ asset('images/icons/visa.svg') }}" alt="Visa" width="40" height="30">
                                    <img src="{{ asset('images/icons/mastercard.svg') }}" alt="Mastercard" width="40" height="30">
                                </div>
                            </div>
                        </div>

                        <div class="card-details-row">
                            <div class="form-group">
                                <label for="cardExpiration">Validade</label>
                                <input type="text" id="cardExpiration" placeholder="MM/AA" data-msg="Informe a validade do cartão">
                            </div>
                            <div class="form-group">
                                <label for="cardCVV">CVV</label>
                                <input type="text" id="cardCVV" placeholder="123" data-msg="Digite o CVV (3 ou 4 dígitos)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cardHolderName">Nome no Cartão</label>
                            <input type="text" id="cardHolderName" placeholder="Nome impresso no cartão" data-msg="Digite o nome impresso no cartão">
                        </div>

                        <div class="form-group">
                            <label for="docNumber">CPF</label>
                            <input type="text" id="docNumber" placeholder="000.000.000-00" data-msg="Digite um CPF válido">
                        </div>

                        <div class="form-group">
                            <label for="installments">Parcelamento</label>
                            <select id="installments" data-msg="Escolha o número de parcelas">
                                <option value="" disabled>Selecione</option>
                                @foreach($cart->installments as $installment => $value)
                                <option value={{$installment}} {{$installment === 1 ? "selected": ""}}>{{$installment}}x
                                    de {{\App\Support\Util\NumberUtil::formatPrice($value)}} {{$installment < 5 ? "Sem juros": ("(" . \App\Support\Util\NumberUtil::formatPrice($value * $installment) . ")")}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="pixFields" class="alternative-payment" style="display: none;">
                        <div class="payment-info">
                            <i class="fas fa-qrcode"></i>
                            <h3>Pagamento via PIX</h3>
                            <p>Após a compra, um QR Code será gerado para pagamento via PIX.</p>
                        </div>
                        <div class="form-group">
                            <label for="cpf-pix">CPF</label>
                            <input type="text" id="cpf-pix" placeholder="000.000.000-00">
                        </div>
                    </div>

                    <div id="ticketFields" class="alternative-payment" style="display: none;">
                        <div class="payment-info">
                            <i class="fas fa-barcode"></i>
                            <h3>Pagamento via Boleto</h3>
                            <p>Após a compra, um boleto será gerado para pagamento.</p>
                        </div>
                        <div class="form-group">
                            <label for="cpf-ticket">CPF</label>
                            <input type="text" id="cpf-ticket" placeholder="000.000.000-00">
                        </div>
                    </div>

                    <div class="coupon-section">
                        <h3><i class="fas fa-tag"></i> Cupom de Desconto</h3>
                        <div class="coupon-input-group">
                            <input type="text" placeholder="Digite seu cupom" id="couponCode">
                            <button type="button" id="applyCoupon" class="btn-apply-coupon">
                                <i class="fas fa-check"></i> Aplicar
                            </button>
                        </div>
                    </div>

                    <div class="final-totals">
                        <div class="total-line">
                            <span>Produtos</span>
                            <span>{{\App\Support\Util\NumberUtil::formatPrice($cart->total)}}</span>
                        </div>
                        @if($cart->discount)
                        <div class="total-line discount">
                            <span>Descontos</span>
                            <span class="discount-value">- {{\App\Support\Util\NumberUtil::formatPrice($cart->discount)}}</span>
                        </div>
                        @endif
                        <div class="total-line">
                            <span>SubTotal</span>
                            <span>{{\App\Support\Util\NumberUtil::formatPrice($cart->subTotal)}}</span>
                        </div>
                        <div class="total-line">
                            <span>Frete</span>
                            <span>{{\App\Support\Util\NumberUtil::formatPrice($cart->shipping)}}</span>
                        </div>
                        <div class="total-line final-total">
                            <span><strong>Total</strong></span>
                            <span><strong>{{\App\Support\Util\NumberUtil::formatPrice($cart->finalPrice)}}</strong></span>
                        </div>
                    </div>

                    <button class="btn-finalize-payment" id="submitPayment" type="button">
                        <i class="fas fa-lock"></i>
                        Finalizar Pedido
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

    <style>
/* ===========================================
   PAYMENT PAGE STYLES - MODERN DESIGN
   =========================================== */

.paymentSection {
    margin: 0 auto;
    max-width: 1400px;
    min-height: calc(100vh - 162px);
            width: 100%;
    background: #f8f9fa;
    padding: 20px 0;
        }

.payment-container {
                display: flex;
                gap: 30px;
    align-items: flex-start;
}

.payment-main {
    flex: 1;
    width: 100%;
}

.order-summary-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
}

.order-summary-card h2 {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 600;
}

.item-count {
    color: #6c757d;
    font-weight: 400;
    font-size: 1rem;
}

.products-list {
            max-height: 400px;
            overflow-y: auto;
    margin-bottom: 20px;
        }

.product-item {
            display: flex;
            align-items: center;
    gap: 16px;
    padding: 16px 0;
    border-bottom: 1px solid #f1f3f4;
}

.product-item:last-child {
    border-bottom: none;
}

.product-image {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-details {
            flex: 1;
        }

.product-details h4 {
    margin: 0 0 8px 0;
    color: #2c3e50;
    font-size: 1rem;
    font-weight: 500;
}

.product-meta {
    display: flex;
    gap: 16px;
    font-size: 0.9rem;
    color: #6c757d;
}

.product-price {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
}

.order-totals {
    border-top: 2px solid #f1f3f4;
    padding-top: 16px;
}

.total-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
    font-size: 1rem;
}

.payment-form-card {
    background: #fff;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    width: 100%;
    max-width: 500px;
}

.payment-form-card h2 {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    color: #2c3e50;
    font-size: 1.5rem;
    font-weight: 600;
}

.payment-method-selector {
            display: flex;
    gap: 12px;
    margin-bottom: 24px;
}

.payment-method-btn {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px 12px;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    font-weight: 500;
    color: #6c757d;
}

.payment-method-btn:hover {
    border-color: #FF7C00;
    background: #fff8f0;
    color: #FF7C00;
}

.payment-method-btn.active {
    background: #FF7C00;
    border-color: #FF7C00;
    color: white;
}

.payment-method-btn i {
    font-size: 1.2rem;
}

.payment-fields {
    margin-bottom: 24px;
}

.card-number-section {
    margin-bottom: 20px;
}

.card-number-section label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #2c3e50;
}

.card-input-group {
    position: relative;
}

.card-input-group input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
            border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.card-input-group input:focus {
    outline: none;
    border-color: #FF7C00;
    box-shadow: 0 0 0 3px rgba(255, 124, 0, 0.1);
}

.card-icons {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    gap: 8px;
}

.card-details-row {
            display: flex;
    gap: 16px;
    margin-bottom: 20px;
}

.form-group {
    flex: 1;
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #2c3e50;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    outline: none;
    border-color: #FF7C00;
    box-shadow: 0 0 0 3px rgba(255, 124, 0, 0.1);
}

.alternative-payment {
    margin-bottom: 24px;
}

.payment-info {
    text-align: center;
    padding: 24px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 20px;
}

.payment-info i {
    font-size: 2rem;
    color: #FF7C00;
    margin-bottom: 12px;
}

.payment-info h3 {
    margin: 0 0 8px 0;
    color: #2c3e50;
}

.payment-info p {
    margin: 0;
    color: #6c757d;
}

.coupon-section {
    margin-bottom: 24px;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 8px;
}

.coupon-section h3 {
            display: flex;
    align-items: center;
    gap: 8px;
    margin: 0 0 16px 0;
    color: #2c3e50;
    font-size: 1.1rem;
}

.coupon-input-group {
    display: flex;
    gap: 12px;
}

.coupon-input-group input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 1rem;
}

.btn-apply-coupon {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
            background: #FF7C00;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
    font-weight: 500;
    transition: background-color 0.3s ease;
}

.btn-apply-coupon:hover {
    background: #e67300;
}

.final-totals {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 24px;
}

.final-totals .total-line {
            display: flex;
            justify-content: space-between;
    margin-bottom: 12px;
    font-size: 1rem;
}

.final-totals .total-line.discount .discount-value {
    color: #dc3545;
}

.final-totals .final-total {
    border-top: 2px solid #e9ecef;
    padding-top: 12px;
    margin-top: 12px;
    font-size: 1.1rem;
    font-weight: 600;
}

.btn-finalize-payment {
    width: 100%;
            display: flex;
            align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 16px 24px;
    background: #FF7C00;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1.1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-finalize-payment:hover {
    background: #e67300;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 124, 0, 0.3);
}

.btn-finalize-payment:active {
    transform: translateY(0);
}

/* Toast Styles */
        .toastify {
            padding: 12px 20px;
            color: #fff;
    border-radius: 8px;
            font-size: 14px;
    font-weight: 500;
        }

        .toastify.success {
            background: #28a745;
        }

        .toastify.error {
            background: #dc3545;
        }

        .error-toast {
            position: fixed;
            top: 20px;
            right: 20px;
    background: #dc3545;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            display: none;
            animation: slideIn 0.3s ease-out;
        }

@keyframes slideIn {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}

/* ===========================================
   RESPONSIVE DESIGN
   =========================================== */

/* Tablet and below */
@media (max-width: 1024px) {
    .payment-container {
        flex-direction: column;
        gap: 20px;
    }
    
    .payment-form-card {
        max-width: 100%;
    }
}

/* Mobile landscape and below */
@media (max-width: 768px) {
    .paymentSection {
        padding: 10px 0;
    }
    
    .order-summary-card,
    .payment-form-card {
        padding: 20px;
    }
    
    .payment-method-selector {
        flex-direction: column;
        gap: 8px;
    }
    
    .payment-method-btn {
        flex-direction: row;
        justify-content: center;
        padding: 12px 16px;
    }
    
    .card-details-row {
        flex-direction: column;
        gap: 0;
    }
    
    .coupon-input-group {
        flex-direction: column;
    }
    
    .btn-apply-coupon {
        justify-content: center;
    }
    
    .product-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .product-image {
        width: 60px;
        height: 60px;
    }
    
    .product-details {
        width: 100%;
    }
    
    .product-meta {
        flex-direction: column;
        gap: 4px;
    }
}

/* Small mobile devices */
@media (max-width: 480px) {
    .order-summary-card h2,
    .payment-form-card h2 {
        font-size: 1.3rem;
    }
    
    .order-summary-card,
    .payment-form-card {
        padding: 16px;
    }
    
    .product-item {
        padding: 12px 0;
    }
    
    .product-details h4 {
        font-size: 0.9rem;
    }
    
    .product-meta {
        font-size: 0.8rem;
    }
    
    .form-group input,
    .form-group select {
        padding: 10px 12px;
        font-size: 16px; /* Prevents zoom on iOS */
    }
    
    .btn-finalize-payment {
        padding: 14px 20px;
        font-size: 1rem;
    }
}

/* Touch improvements */
@media (hover: none) and (pointer: coarse) {
    .payment-method-btn:hover {
        border-color: #e9ecef;
        background: #f8f9fa;
        color: #6c757d;
    }
    
    .payment-method-btn:active {
        border-color: #FF7C00;
        background: #fff8f0;
        color: #FF7C00;
    }
    
    .btn-apply-coupon:hover {
        background: #FF7C00;
    }
    
    .btn-apply-coupon:active {
        background: #e67300;
    }
    
    .btn-finalize-payment:hover {
        background: #FF7C00;
        transform: none;
        box-shadow: none;
    }
    
    .btn-finalize-payment:active {
        background: #e67300;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(255, 124, 0, 0.3);
    }
}
</style>

<div id="error-toast" class="error-toast" style="display: none;">
    <div class="error-content">
        <i class="fas fa-exclamation-circle"></i>
        <span id="error-message"></span>
    </div>
</div>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script src="https://unpkg.com/imask"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    IMask(document.getElementById('cardNumber'), {
        mask: '0000 0000 0000 0000'
    });

    IMask(document.getElementById('cardExpiration'), {
        mask: 'MM{/}YY',
        blocks: {
            MM: {
                mask: IMask.MaskedRange,
                from: 1,
                to: 12,
                maxLength: 2
            },
            YY: {
                mask: IMask.MaskedRange,
                from: 1,
                to: 99,
                maxLength: 2
            }
        }
    });;

    IMask(document.getElementById('cardCVV'), {
        mask: '0000'
    });

    IMask(document.getElementById('docNumber'), {
        mask: '000.000.000-00'
    });

    IMask(document.getElementById('cpf-pix'), {
        mask: '000.000.000-00'
    });

    IMask(document.getElementById('cpf-ticket'), {
        mask: '000.000.000-00'
    });


    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const paymentButtons = document.querySelectorAll('.payment-method-btn');
    const cardFields = document.getElementById('card-fields');
    const cardIcons = document.getElementById('card-icons');
    const pixField = document.getElementById('pixFields');
    const ticketField = document.getElementById('ticketFields');

        console.log('Payment buttons found:', paymentButtons.length);
        console.log('Card fields:', cardFields);
        console.log('PIX field:', pixField);
        console.log('Ticket field:', ticketField);

        paymentButtons.forEach((button, index) => {
        let method = button.getAttribute('data-method');
            console.log(`Button ${index}: ${method}`);

            button.addEventListener('click', (e) => {
                e.preventDefault();
                console.log('Clicked method:', method);
                
                document.getElementById('paymentMethod').value = method;

                // Remove active class from all buttons
                paymentButtons.forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                button.classList.add('active');

            if (method === 'credit_card') {
                    if (cardFields) cardFields.style.display = 'block';
                    if (cardIcons) cardIcons.style.display = 'flex';
                    if (pixField) pixField.style.display = 'none';
                    if (ticketField) ticketField.style.display = 'none';
                } else if (method === 'pix') {
                    if (cardFields) cardFields.style.display = 'none';
                    if (cardIcons) cardIcons.style.display = 'none';
                    if (pixField) pixField.style.display = 'block';
                    if (ticketField) ticketField.style.display = 'none';
                } else if (method === 'ticket') {
                    if (cardFields) cardFields.style.display = 'none';
                    if (cardIcons) cardIcons.style.display = 'none';
                    if (pixField) pixField.style.display = 'none';
                    if (ticketField) ticketField.style.display = 'block';
                }
            });
        });
    });


    const mp = new MercadoPago("TEST-0de9a30b-3ac2-408d-b2bf-7c50fba3625f", {
        locale: "pt-BR"
    });

    function isValidCPF(cpf) {
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

        let sum = 0;
        for (let i = 0; i < 9; i++) sum += parseInt(cpf.charAt(i)) * (10 - i);
        let rev = 11 - (sum % 11);
        if (rev === 10 || rev === 11) rev = 0;
        if (rev !== parseInt(cpf.charAt(9))) return false;

        sum = 0;
        for (let i = 0; i < 10; i++) sum += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (sum % 11);
        if (rev === 10 || rev === 11) rev = 0;
        return rev === parseInt(cpf.charAt(10));
    }

    function isValidCardNumber(number) {
        return number.replace(/\D/g, '').length === 16;
    }

    function isValidCVV(cvv) {
        return /^\d{3,4}$/.test(cvv);
    }

    function isValidCardExpiration(cardExpiration) {
        return /^\d{4}$/.test(cardExpiration.replaceAll('/', ''));
    }

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

    document.getElementById("submitPayment").onclick = async function(e) {
        let paymentMethod = document.getElementById("paymentMethod").value;
        let cardNumber = document.getElementById('cardNumber');
        let cardExpiration = document.getElementById('cardExpiration');
        let carDocNumber = document.getElementById('docNumber');
        let cvv = document.getElementById('cardCVV');
        let cardHolderName = document.getElementById('cardHolderName');

        [cardNumber, cardExpiration, carDocNumber, cvv].forEach(el => {
            if (el) el.setCustomValidity('');
        });

        if (paymentMethod === "credit_card") {
            if (cardNumber.value.trim() === '' || !isValidCardNumber(cardNumber.value)) {
                cardNumber.setCustomValidity('Número do cartão inválido');
                cardNumber.reportValidity();
                return;
            }

            if (cardExpiration.value.trim() === '' || !isValidCardExpiration(cardExpiration.value)) {
                cardExpiration.setCustomValidity('Validade inválida');
                cardExpiration.reportValidity();
                return;
            }

            if (cvv.value.trim() === '' || !isValidCVV(cvv.value)) {
                cvv.setCustomValidity('CVV inválido');
                cvv.reportValidity();
                return;
            }

            if (cardHolderName.value.trim() === '') {
                cardHolderName.setCustomValidity('Digite o nome impresso no cartão');
                cardHolderName.reportValidity();
                return;
            }

            if (carDocNumber.value.trim() === '' || !isValidCPF(carDocNumber.value)) {
                carDocNumber.setCustomValidity('CPF inválido');
                carDocNumber.reportValidity();
                return;
            }
        } else {
            let docNumber = document.getElementById('cpf');
            if (docNumber.value.trim() === '' || !isValidCPF(docNumber.value)) {
                docNumber.setCustomValidity('CPF inválido');
                docNumber.reportValidity();
                return;
            }
        }

        let paymentData = {
            total_price: parseFloat('{{$cart->total}}'),
            final_price: parseFloat('{{$cart->subTotal}}'),
            installments: 1,
            installment_price: parseFloat('{{$cart->subTotal}}'),
            payment_method_id: paymentMethod === "credit_card" ? "visa" : (paymentMethod === "pix" ? "pix" : "bolbradesco"),
            method: paymentMethod
        };

        if (paymentMethod === "credit_card") {
            try {
                const token = await createCardToken();
                paymentData.token = token;

                let installment = parseInt(document.getElementById("installments").value)
                let installments = @json($cart->installments);
                let installmentPrice = installments[installment];

                paymentData.installments = installment;
                paymentData.installment_price = installmentPrice;
                paymentData.final_price = installmentPrice * installment;


                const bin = cardNumber.value.replace(/\D/g, '').substring(0, 6);

                const paymentMethods = await mp.getPaymentMethods({
                    bin
                });

                if (paymentMethods && paymentMethods.results.length > 0) {
                    paymentData.payment_method_id = paymentMethods.results[0].id;
                    paymentData.issuer_id = paymentMethods.results[0].issuer.id;
                }

            } catch (error) {
                console.error("Erro ao gerar token do cartão:", error);
                return;
            }
        }

        fetch("/checkout/pay", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(paymentData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success === false) {
                    showToast(data.message || 'Erro ao processar pagamento.', true);
                    return;
                }
                if (data.success === true && data.orderId) {
                    window.location.href = `/checkout/payment-confirmed/${data.orderId}`;
                    return;
                }
                document.getElementById("paymentResponse").innerHTML = `<p>${data.message}</p>`;
            })
            .catch(error => {
                showToast('Erro inesperado ao processar pagamento.', true);
                console.error(error);
            });

        async function createCardToken() {
            return new Promise((resolve, reject) => {
                console.log({
                    cardNumber: cardNumber.value.replace(/\D/g, ''),
                    cardholderName: cardHolderName.value,
                    securityCode: cvv.value.trim(),
                    cardExpirationMonth: cardExpiration.value.split("/")[0],
                    cardExpirationYear: `20${cardExpiration.value.split("/")[1]}`,
                    identificationType: 'CPF',
                    identificationNumber: carDocNumber.value.replaceAll('.', '').replaceAll('-', ''),
                });
                mp.createCardToken({
                    cardNumber: cardNumber.value.replace(/\D/g, ''),
                    cardholderName: cardHolderName.value,
                    securityCode: cvv.value.trim(),
                    cardExpirationMonth: cardExpiration.value.split("/")[0],
                    cardExpirationYear: `20${cardExpiration.value.split("/")[1]}`,
                    identificationType: 'CPF',
                    identificationNumber: carDocNumber.value.replaceAll('.', '').replaceAll('-', ''),
                }).then(response => {
                    resolve(response.id);
                }).catch(error => {
                    reject(error);
                });
            });
        }

    };
</script>
@endsection
