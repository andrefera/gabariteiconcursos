@extends('layouts.app')
@section('title', 'Ellon Sports | Pagamento')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Toastify -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: system-ui, sans-serif;
            background: #fafafa;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            padding: 2rem;
            width: 100%;
            gap: 50px;
            background-color: #fff;
        }

        @media (max-width: 1000px) {
            .container {
                display: flex;
                flex-direction: column;
                padding: 2rem;
                width: 100%;
                gap: 30px;
                background-color: #fff;
                align-items: center;
            }
        }

        .left,
        .right {
            max-width: 600px;
            width: 100%;
        }

        h2 {
            margin-bottom: 1rem;
        }

        .card {
            border: 1px solid #eee;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .card img {
            width: 80px;
            border-radius: 8px;
        }

        .products {
            height: 100%;
            max-height: 400px;
            overflow-y: auto;
        }

        .product {
            display: flex;
            gap: 1rem;
            align-items: center;
            justify-content: space-between;
        }

        .details {
            flex: 1;
        }

        .details small {
            display: block;
            color: #777;
        }

        .discount,
        .recommended {
            background: #f8f8f8;
            padding: 1rem;
            border-radius: 8px;
            border: 1px dashed #ccc;
            margin-bottom: 1rem;
        }

        .couponLabel {
            display: flex;
            gap: 25px;
        }

        .couponLabel button {
            width: 120px;
            height: 37px;
            background: #FF7C00;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .recommended .add-to-cart img {
            width: 80px;
            border-radius: 8px;
        }

        .recommended .add-to-cart {
            display: flex;
            gap: 10px;
        }

        .totals {
            border-top: 1px solid #eee;
            padding-top: 1rem;
        }

        .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .totals .discount-span {
            color: #a40000;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 0.6rem;
            margin-bottom: 1rem;
            border-radius: 6px;
            border: 1px solid #ccc;
            height: 37px;
        }

        .btn {
            width: 100%;
            padding: 1rem;
            background: #FF7C00;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .payment-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .payment-options button {
            flex: 1;
            margin: 0 0.25rem;
            padding: 0.5rem;
            background: #eee;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
        }

        .payment-methods {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .credit-card {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .payment-methods img {
            width: 50px;
        }

        .card-fields {
            display: block;
        }

        .cpf-field {
            text-align: center;
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

        /* Error Toast */
        .error-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff4444;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 10000;
            display: none;
            animation: slideIn 0.3s ease-out;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left">
            <h2>Resumo do Pedido <small>({{$cart->totalProducts}} itens)</small></h2>
            <div class="products">
                @foreach($cart->products as $product)
                <div class="card product">
                    <img src={{$product->imageUrl ?? ''}} alt={{$product->name}}>
                    <div class="details">
                        <strong>{{$product->name}}</strong>
                        <small>Tamanho: <strong>{{$product->size}}</strong> Qtd: {{$product->quantity}}</small>
                    </div>
                    <div><strong>{{$product->priceLabel}}</strong></div>
                </div>
                @endforeach
            </div>
            <div class="totals">
                <div><span>Subtotal</span><span>{{\App\Support\Util\NumberUtil::formatPrice($cart->subTotal)}}</span></div>
            </div>

            <div class="recommended">
                <div class="add-to-cart">
                    <img
                        src="https://promantos.com.br/cdn/shop/files/camisa-camiseta-blusa-do-botafogo-fogao-reebook-nova-lancamento-da-temporada-ano-2024_25-24_25-i-1-titular-principal-primeira-home-listrada-alvinegra-preta-e-branco-masculina-versao-m_544fe31a-d863-470a-91ed-3d06b62b6b3b_700x.jpg?v=1719517896&quot;"
                        alt="Headset">
                    <div>
                        <strong>Camisa Torcedor São Paulo Treino 2025/26 - Masculina</strong><br>
                        <del>R$599,99</del>
                        <strong style="color: red;">R$320,99</strong><br>
                    </div>
                </div>
                <button class="btn" style="margin-top: 0.5rem;">Compre Junto</button>
            </div>
        </div>

        <div class="right">
            <h2>Pagamento</h2>

            <form id="paymentForm">
                <div class="payment-options">
                    <button type="button" data-method="credit_card">Cartão de Crédito</button>
                    <button type="button" data-method="pix">Pix</button>
                    <button type="button" data-method="ticket">Boleto</button>
                </div>

                <input id="paymentMethod" type="hidden" value="credit_card">
                <div class="card-fields" id="card-fields">
                    <div class="credit-card">
                        <input type="text" id="cardNumber" placeholder="Número do Cartão"
                            data-msg="Digite um número de cartão válido">

                        <div class="payment-methods" id="card-icons">
                            <img src="{{ asset('images/icons/visa.svg') }}" alt="Visa" width="60" height="50">
                            <img src="{{ asset('images/icons/mastercard.svg') }}" alt="Mastercard" width="60" height="50">
                        </div>
                    </div>
                    <input type="text" id="cardExpiration" placeholder="MM/AA" data-msg="Informe a validade do cartão">
                    <input type="text" id="cardCVV" placeholder="CVV" data-msg="Digite o CVV (3 ou 4 dígitos)">
                    <input type="text" id="cardHolderName" placeholder="Nome no Cartão"
                        data-msg="Digite o nome impresso no cartão">
                    <input type="text" id="docNumber" placeholder="CPF" data-msg="Digite um CPF válido">
                    <select id="installments" data-msg="Escolha o número de parcelas">
                        <option value="" disabled>Selecione</option>
                        @foreach($cart->installments as $installment => $value)
                        <option value={{$installment}} {{$installment === 1 ? "selected": ""}}>{{$installment}}x
                            de {{\App\Support\Util\NumberUtil::formatPrice($value)}} {{$installment < 5 ? "Sem juros": ("(" . \App\Support\Util\NumberUtil::formatPrice($value * $installment) . ")")}}</option>
                        @endforeach
                    </select>
                </div>

                <div id="pixFields" class="cpf-field" style="display: none;">
                    <p><strong>Após a compra, um QR Code será gerado para pagamento via PIX.</strong></p>
                </div>

                <div id="ticketFields" class="cpf-field" style="display: none;">
                    <p><strong>Após a compra, um boleto será gerado para pagamento.</strong></p>
                </div>

                <div id="cpf-field" style="display: none;">
                    <input type="text" placeholder="CPF" id="cpf">
                </div>

                <div class="discount">
                    <strong>Cupom</strong>
                    <div class="couponLabel">
                        <input type="text">
                        <button id="applyCoupon" type="button">Aplicar</button>
                    </div>
                </div>

                <div class="totals">
                    <div><span>Produtos</span><span>{{\App\Support\Util\NumberUtil::formatPrice($cart->total)}}</span></div>
                    @if($cart->discount)
                    <div><span>Descontos</span><span
                            class="discount-span">- {{\App\Support\Util\NumberUtil::formatPrice($cart->discount)}}</span>
                    </div>
                    @endif
                    <div><span>SubTotal</span><span>{{\App\Support\Util\NumberUtil::formatPrice($cart->subTotal)}}</span>
                    </div>
                    <div><span>Frete</span><span>{{\App\Support\Util\NumberUtil::formatPrice($cart->shipping)}}</span></div>
                    <div>
                        <strong>Total</strong><strong>{{\App\Support\Util\NumberUtil::formatPrice($cart->finalPrice)}}</strong>
                    </div>
                </div>

                <button class="btn" id="submitPayment" type="button">Finalizar Pedido</button>
            </form>
        </div>
    </div>
</body>

</html>

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

    IMask(document.getElementById('cpf'), {
        mask: '000.000.000-00'
    });


    const paymentButtons = document.querySelectorAll('.payment-options button');
    const cardFields = document.getElementById('card-fields');
    const cardIcons = document.getElementById('card-icons');
    const cpfField = document.getElementById('cpf-field');
    const pixField = document.getElementById('pixFields');
    const ticketField = document.getElementById('ticketFields');

    paymentButtons.forEach(button => {
        let method = button.getAttribute('data-method');

        if (method === 'credit_card') {
            button.style.background = '#FF7C00';
            button.style.color = 'white';
        }

        button.addEventListener('click', () => {
            document.getElementById('paymentMethod').value = method

            if (method === 'credit_card') {
                cardFields.style.display = 'block';
                cardIcons.style.display = 'flex';
                cpfField.style.display = 'none';
                pixField.style.display = 'none';
                ticketField.style.display = 'none';
            } else {
                cardFields.style.display = 'none';
                cardIcons.style.display = 'none';
                cpfField.style.display = 'block';

                if (method === 'pix') {
                    pixField.style.display = 'block';
                    ticketField.style.display = 'none';
                } else {
                    ticketField.style.display = 'block';
                    pixField.style.display = 'none';
                }

            }

            paymentButtons.forEach((btn) => {
                btn.style.background = '#eee'
                btn.style.color = '#000'
            });
            button.style.background = '#FF7C00';
            button.style.color = 'white';
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
                    window.location.href = `/checkout/pagamento-confirmado/${data.orderId}`;
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