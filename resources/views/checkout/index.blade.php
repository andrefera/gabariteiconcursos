@extends('layouts.app')
@section('title', 'Ellon Sports | Confirmar compra')
<link rel="stylesheet" href="{!! asset('assets/css/checkout.css') !!}">
@section('content')
    <h2 class="mb-4">Finalizar Compra</h2>
    <div class="container">
        <!-- Lista de produtos -->
        <div class="card mb-3">
            <div class="card-header">Seu Carrinho</div>
            <div class="card-body">
                {{-- @foreach ($cart as $item) --}}
                {{-- <div class="d-flex justify-content-between"> --}}
                {{-- <span>{{ $item['name'] }} ({{ $item['quantity'] }}x)</span> --}}
                {{-- <span>R$ {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</span> --}}
                {{-- </div> --}}
                {{-- @endforeach --}}
                <div class="d-flex justify-content-between">
                    <span>Camisa Flamengo 2025 (2x)</span>
                    <span>R$ 100,00</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between font-weight-bold">
                    <span>Total:</span>
                    <span>R$ 100,00</span>
                </div>
            </div>
        </div>

        <form id="paymentForm">
            <h4>Escolha a forma de pagamento:</h4>
            <select id="paymentMethod">
                <option value="pix">PIX</option>
                <option value="credit_card">Cartão de Crédito</option>
                <option value="boleto">Boleto</option>
            </select>

            <div id="pixFields">
                <p>Após a compra, um QR Code será gerado para pagamento via PIX.</p>
            </div>

            <div id="cardFields" class="hidden">
                <input type="text" id="cardNumber" placeholder="Número do Cartão" data-checkout="cardNumber">
                <input type="text" id="cardExpiration" placeholder="MM/AA">
                <input type="text" id="cardCVV" placeholder="CVV" data-checkout="securityCode">
                <input type="text" id="cardHolderName" placeholder="Nome no Cartão">
                <input type="text" id="docNumber" placeholder="CPF">
                <select id="installments"></select>
            </div>

            <div id="boletoFields" class="hidden">
                <p>Após a compra, um boleto será gerado para pagamento.</p>
            </div>

            <button type="submit">Pagar</button>
        </form>

        <div id="paymentResponse"></div>
    </div>

    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>

        const mp = new MercadoPago("TEST-0de9a30b-3ac2-408d-b2bf-7c50fba3625f", {locale: "pt-BR"});

        document.getElementById("paymentMethod").addEventListener("change", function () {
            document.getElementById("cardFields").classList.add("hidden");
            document.getElementById("pixFields").classList.add("hidden");
            document.getElementById("boletoFields").classList.add("hidden");

            if (this.value === "credit_card") {
                document.getElementById("cardFields").classList.remove("hidden");
            } else if (this.value === "pix") {
                document.getElementById("pixFields").classList.remove("hidden");
            } else if (this.value === "boleto") {
                document.getElementById("boletoFields").classList.remove("hidden");
            }
        });

        document.getElementById("paymentForm").addEventListener("submit", async function (event) {
            event.preventDefault();

            const paymentMethod = document.getElementById("paymentMethod").value;
            let paymentData = {
                amount: 100.00,
                payment_method_id: paymentMethod === "credit_card" ? "visa" : (paymentMethod === "pix" ? "pix" : "bolbradesco"),
                email: "comprador@email.com",
            };

            if (paymentMethod === "credit_card") {
                try {
                    const token = await createCardToken();
                    paymentData.token = token;
                    paymentData.installments = document.getElementById("installments").value;
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
                        resolve(response.id);
                    }).catch(error => {
                        reject(error);
                    });
                });
            }
        });
    </script>
@endsection

<style>
    /* Variáveis CSS */
    :root {
        --primary-color: #FF7F00;
        --secondary-color: #6c757d;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --light-bg: #f8f9fa;
        --dark-bg: #333;
        --border-radius: 10px;
        --input-border-color: #ddd;
        --input-focus-color: var(--primary-color);
        --shadow-color: rgba(0, 0, 0, 0.1);
        --card-header-bg: #FF7F00;
        --card-header-text-color: #fff;
    }

    .container {
        display: flex;
        justify-content: space-between;
        margin: 40px auto;
        padding: 30px;
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: 0 4px 12px var(--shadow-color);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-size: 2rem;
        font-weight: 600;
        color: var(--dark-bg);
        letter-spacing: 0.5px;
    }

    .card {
        margin-bottom: 30px;
        border: none;
        box-shadow: 0 2px 8px var(--shadow-color);
        border-radius: var(--border-radius);
        transition: all 0.3s ease-in-out;
    }

    .card-header {
        background: var(--card-header-bg);
        color: var(--card-header-text-color);
        font-size: 1.25rem;
        font-weight: 600;
        padding: 15px;
        border-top-left-radius: var(--border-radius);
        border-top-right-radius: var(--border-radius);
    }

    .card-body {
        padding: 25px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
    }

    .form-group input {
        border: 1px solid var(--input-border-color);
        border-radius: 8px;
        padding: 12px;
        font-size: 1rem;
        width: 100%;
        transition: border-color 0.3s ease-in-out;
    }

    .form-group input:focus {
        border-color: var(--input-focus-color);
        outline: none;
    }

    .btn {
        font-size: 1.1rem;
        font-weight: 600;
        padding: 14px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
        width: 100%;
        margin-bottom: 15px;
    }

    .btn-success {
        background: var(--success-color);
        color: #fff;
        border: none;
    }

    .btn-success:hover {
        background: darken(var(--success-color), 10%);
    }

    .btn-primary {
        background: var(--primary-color);
        color: #fff;
        border: none;
    }

    .btn-primary:hover {
        background: darken(var(--primary-color), 10%);
    }

    .btn-secondary {
        background: var(--secondary-color);
        color: #fff;
        border: none;
    }

    .btn-secondary:hover {
        background: darken(var(--secondary-color), 10%);
    }

    #paymentFields {
        background: var(--light-bg);
        padding: 20px;
        border-radius: 8px;
        border: 1px solid var(--input-border-color);
        margin-top: 20px;
    }

    #paymentFields p {
        font-size: 1.1rem;
        font-weight: 500;
        color: #555;
    }

    .card-footer {
        background: var(--light-bg);
        padding: 15px;
        text-align: center;
        border-bottom-left-radius: var(--border-radius);
        border-bottom-right-radius: var(--border-radius);
        font-size: 0.9rem;
        color: #888;
    }

    hr {
        border: 1px solid var(--input-border-color);
        margin: 20px 0;
    }

    .hidden {
        display: none;
    }
</style>
