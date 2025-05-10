@extends('layouts.app')
@section('title', 'Ellon Sports | Pagamento')
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

        .left, .right {
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

        .discount, .recommended {
            background: #f8f8f8;
            padding: 1rem;
            border-radius: 8px;
            border: 1px dashed #ccc;
            margin-bottom: 1rem;
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

        input[type="text"], select {
            width: 100%;
            padding: 0.6rem;
            margin-bottom: 1rem;
            border-radius: 6px;
            border: 1px solid #ccc;
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

        .payment-methods img {
            height: 24px;
        }

        .card-fields {
            display: block;
        }

        .cpf-field {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="left">
        <h2>Resumo do Pedido <small>(2 itens)</small></h2>

        <div class="card product">
            <img
                src="https://promantos.com.br/cdn/shop/files/camisa-camiseta-blusa-do-botafogo-fogao-reebook-nova-lancamento-da-temporada-ano-2024_25-24_25-i-1-titular-principal-primeira-home-listrada-alvinegra-preta-e-branco-masculina-versao-m_544fe31a-d863-470a-91ed-3d06b62b6b3b_700x.jpg?v=1719517896&quot;"
                alt="PlayStation 5">
            <div class="details">
                <strong>Camisa Torcedor Botafogo I 2024/25 - Masculina</strong>
                <small>Qtd: 1</small>
            </div>
            <div><strong>R$499,99</strong></div>
        </div>

        <div class="card product">
            <img
                src="https://promantos.com.br/cdn/shop/files/camisa-camiseta-blusa-do-botafogo-fogao-reebook-nova-lancamento-da-temporada-ano-2024_25-24_25-i-1-titular-principal-primeira-home-listrada-alvinegra-preta-e-branco-masculina-versao-m_544fe31a-d863-470a-91ed-3d06b62b6b3b_700x.jpg?v=1719517896&quot;"
                alt="Headset">
            <div class="details">
                <strong>Camisa Torcedor Botafogo I 2024/25 - Masculina</strong>
                <small>Qtd: 1</small>
            </div>
            <div><strong>R$99,99</strong></div>
        </div>

        <div class="totals">
            <div><span>Subtotal</span><span>R$599,98</span></div>
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

            <div class="payment-methods" id="card-icons">
                <img src="https://img.icons8.com/color/48/visa.png" alt="Visa">
                <img src="https://img.icons8.com/color/48/mastercard-logo.png" alt="Mastercard">
                <img src="https://img.icons8.com/color/48/amex.png" alt="Amex">
            </div>

            <div class="card-fields" id="card-fields">
                <input type="text" id="cardNumber" placeholder="Número do Cartão"
                       data-msg="Digite um número de cartão válido">
                <input type="text" id="cardExpiration" placeholder="MM/AA" data-msg="Informe a validade do cartão">
                <input type="text" id="cardCVV" placeholder="CVV" data-msg="Digite o CVV (3 ou 4 dígitos)">
                <input type="text" id="cardHolderName" placeholder="Nome no Cartão"
                       data-msg="Digite o nome impresso no cartão">
                <input type="text" id="docNumber" placeholder="CPF" data-msg="Digite um CPF válido">
                <select id="installments" data-msg="Escolha o número de parcelas">
                    <option value="" disabled>Selecione as parcelas</option>
                    <option value="1" selected>1x de R$599,98</option>
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
                <strong>Cupom</strong> <br>
                <input type="text">
            </div>

            <div class="totals">
                <div><span>Subtotal</span><span>R$599,98</span></div>
                <div><span>Frete</span><span>R$00,00</span></div>
                <div><strong>Total</strong><strong>R$599,98</strong></div>
            </div>

            <button class="btn" type="submit">Finalizar Pedido</button>
        </form>
    </div>
</div>
</body>
</html>

<script src="https://sdk.mercadopago.com/js/v2"></script>
<script src="https://unpkg.com/imask"></script>

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
    });
    ;

    IMask(document.getElementById('cardCVV'), {
        mask: '0000'
    });

    IMask(document.getElementById('docNumber'), {
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


    const mp = new MercadoPago("TEST-0de9a30b-3ac2-408d-b2bf-7c50fba3625f", {locale: "pt-BR"});

    document.getElementById("paymentForm").addEventListener("submit", async function (event) {
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
            number = number.replace(/\D/g, '');

            if (number.length < 13 || number.length > 19) return false;

            let sum = 0;
            let shouldDouble = false;

            for (let i = number.length - 1; i >= 0; i--) {
                let digit = parseInt(number.charAt(i));

                if (shouldDouble) {
                    digit *= 2;
                    if (digit > 9) digit -= 9;
                }

                sum += digit;
                shouldDouble = !shouldDouble;
            }

            return sum % 10 === 0;
        }

        function isValidCVV(cvv) {
            return /^\d{3,4}$/.test(cvv);
        }

        const fields = this.querySelectorAll('[data-msg]');
        let isValid = true;

        for (const field of fields) {
            if (!isValid) break;

            let customMessage = field.dataset.msg || 'Campo obrigatório';
            field.setCustomValidity('');

            if (field.value.trim() === '') {
                field.setCustomValidity(customMessage);
                isValid = false;
                field.reportValidity();
                break;
            }

            if (field.id === 'docNumber' && !isValidCPF(field.value)) {
                field.setCustomValidity('CPF inválido');
                isValid = false;
                field.reportValidity();
                break;
            }

            if (field.id === 'cardNumber' && !isValidCardNumber(field.value)) {
                field.setCustomValidity('Número do cartão inválido');
                isValid = false;
                field.reportValidity();
                break;
            }

            if (field.id === 'cardCVV' && !isValidCVV(field.value)) {
                field.setCustomValidity('CVV inválido (3 ou 4 dígitos)');
                isValid = false;
                field.reportValidity();
                break;
            }
        }

        if (!isValid) {
            event.preventDefault();
            return;
        }



        const paymentMethod = document.getElementById("paymentMethod").value;
        let paymentData = {
            total_price: 100.00,
            final_price: 100.00,
            installment_price: 100.00,
            shipping_price: 100.00,
            shipping_method: 'correios',
            shipping_company: 'correios',
            shipping_days: 7,
            payment_method_id: paymentMethod === "credit_card" ? "visa" : (paymentMethod === "pix" ? "pix" : "bolbradesco"),
            email: "comprador@email.com",
            document: paymentMethod === "credit_card" ? document.getElementById('docNumber').value : document.getElementById('cpf').value,
            method: paymentMethod
        };

        if (paymentMethod === "credit_card") {
            try {
                const token = await createCardToken();
                paymentData.token = token;
                // paymentData.installments = document.getElementById("installments").value;
                paymentData.installments = 1;
                paymentData.docNumber = document.getElementById("docNumber").value;

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
                document.getElementById("paymentResponse").innerHTML = `<p>${data.message}</p>`;

                if (data.qr_code) {
                    document.getElementById("paymentResponse").innerHTML += `<img src="data:image/png;base64,${data.qr_code}" alt="QR Code PIX">`;
                }

                if (data.boleto_url) {
                    document.getElementById("paymentResponse").innerHTML += `<a href="${data.boleto_url}" target="_blank">Baixar Boleto</a>`;
                }
            })
            .catch(error => console.error(error));

        async function createCardToken() {
            return new Promise((resolve, reject) => {
                mp.createCardToken({
                    cardNumber: document.getElementById("cardNumber").value,
                    securityCode: document.getElementById("cardCVV").value,
                    expirationMonth: document.getElementById("cardExpiration").value.split("/")[0],
                    expirationYear: `20${document.getElementById("cardExpiration").value.split("/")[1]}`,
                    cardholderName: document.getElementById("cardHolderName").value,
                    identificationType: "CPF",
                    identificationNumber: document.getElementById("docNumber").value
                }).then(response => {
                    console.log(response)
                    resolve(response.id);
                }).catch(error => {
                    reject(error);
                });
            });
        }
    });
</script>
@endsection
