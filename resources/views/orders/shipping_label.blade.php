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
    @foreach($orders as $key => $order)
        <div class="etiqueta">
            <div class="logo-container">
                <img src="{{ public_path('logo.png') }}" class="logo" alt="Logo">
            </div>
            <p><span class="bold">Pedido:</span> #{{ $order->increment_id }}</p>
            <p><span class="bold">Realizado em:</span> {{$order->created_at}}</p>
            <p class="bold">Destinatário:</p>
            <p class="margin">{{ $order->user_name }}</p>
            <p class="margin">{{$order->street}}, {{ $order->number }}</p>
            <p class="margin">{{$order->neighborhood}}</p>
            <p class="margin">{{$order->city}}, {{$order->state}}, {{$order->zip_code}}</p>
            <p class="margin">Brasil</p>
        </div>
        @if($key > 0 && $key % 6 == 0)
            <div class="limitation"></div>
        @endif
    @endforeach
</div>

</body>
</html>
