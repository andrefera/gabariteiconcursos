<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiquetas</title>
    <style>
        @page {
            size: A4;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .etiquetas-container {
            text-align: center;
            font-size: 12px; /* Ajuste para melhor renderização */
        }

        .etiqueta {
            display: inline-block;
            width: 46%; /* Garante duas etiquetas por linha */
            border: 1px dashed black;
            padding: 10px;
            box-sizing: border-box;
            vertical-align: top;
            text-align: left; /* Alinha o texto corretamente */
            margin-bottom: 15px;
        }

        .etiqueta .logo-container {
            text-align: right; /* Alinha a logo à direita */
        }

        .etiqueta .logo {
            width: 90px;
            height: auto;
        }

        .bold {
            font-weight: bold;
        }

        .margin {
            margin: 4px 0;
        }

        .limitation {
            margin: 100px 0;
        }

    </style>
</head>
<body>

<div class="etiquetas-container">
    @for ($i = 1; $i <= 100; $i++)
        <div class="etiqueta">
            <div class="logo-container">
                <img src="{{ public_path('logo.png') }}" class="logo" alt="Logo">
            </div>
            <p><span class="bold">Pedido:</span> #{{ 2900 + $i }}</p>
            <p><span class="bold">Realizado em:</span> 10/03/2025</p>
            <p class="bold">Destinatário:</p>
            <p class="margin">Nome Exemplo {{ $i }}</p>
            <p class="margin">Rua Exemplo, {{ $i }}00</p>
            <p class="margin">Bairro Exemplo0</p>
            <p class="margin">Cidade Exemplo, Estado Exemplo, 00000-000</p>
            <p class="margin">Brasil</p>
        </div>
        @if($i % 6 == 0)
            <div class="limitation"></div>
        @endif
    @endfor
</div>

</body>
</html>
