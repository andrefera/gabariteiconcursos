@extends('layouts.app')
@section('title', 'Pagamento Confirmado')
@section('content')
    <div class="container" style="max-width: 600px; margin: 40px auto; background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); padding: 2rem;">
        <div id="order-status-content">
            @if(isset($order))
                <h2 style="text-align:center;">Confirmação do Pedido</h2>
                <div style="text-align:center; margin-bottom: 2rem;">
                    @if($order->payment_status === 'paid')
                        <div style="font-size: 60px; color: #2ecc40; margin-bottom: 10px;">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="12" fill="#2ecc40"/><path d="M7 13.5L10.5 17L17 10.5" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h3>Pagamento aprovado!</h3>
                        <p>Seu pedido foi confirmado e está sendo processado.</p>
                    @elseif($order->payment_status === 'waiting_payment')
                        <div style="font-size: 60px; color: #FF7C00; margin-bottom: 10px;">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="12" fill="#FF7C00"/><path d="M12 7V13" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="17" r="1" fill="#fff"/></svg>
                        </div>
                        <h3>Aguardando pagamento</h3>
                        @if($order->payment_method === 'pix')
                            <p>Escaneie o QR Code abaixo para pagar via PIX:</p>
                            @if($order->pix_qr_code)
                                <img src="data:image/png;base64,{{$order->pix_qr_code}}" alt="QR Code PIX" style="max-width: 220px; margin: 1rem auto; display:block;"/>
                            @endif
                            @if($order->pix_code)
                                <div style="background:#f8f8f8;padding:10px;border-radius:8px;word-break:break-all;">{{$order->pix_code}}</div>
                            @endif
                        @elseif($order->payment_method === 'ticket')
                            <p>Use o código de barras abaixo para pagar o boleto:</p>
                            @if($order->boleto_barcode)
                                <div style="background:#f8f8f8;padding:10px;border-radius:8px;word-break:break-all;">{{$order->boleto_barcode}}</div>
                            @endif
                            @if($order->boleto_url)
                                <a href="{{$order->boleto_url}}" target="_blank" class="btn" style="margin-top:1rem;display:inline-block;">Baixar Boleto</a>
                            @endif
                        @endif
                    @else
                        <div style="font-size: 60px; color: #a40000; margin-bottom: 10px;">
                            <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="12" r="12" fill="#a40000"/><path d="M8 8L16 16M16 8L8 16" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h3>Pagamento não realizado</h3>
                        <p>{{$order->payment_message ?? 'Houve um problema ao processar seu pagamento.'}}</p>
                    @endif
                </div>
                <div style="border-top:1px solid #eee; padding-top:1rem;">
                    <h4>Resumo do Pedido</h4>
                    <ul style="list-style:none;padding:0;">
                        @foreach($order->items as $item)
                            <li style="margin-bottom:10px;">
                                <strong>{{$item['product_name']}}</strong> <br>
                                Tamanho: {{$item['size']}} | Qtd: {{$item['quantity']}} <br>
                                <span style="color:#777;">{{$item['price_label']}}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div style="margin-top:1rem;">
                        <div><b>Subtotal:</b> {{\App\Support\Util\NumberUtil::formatPrice($order->final_price)}}</div>
                        <div><b>Frete:</b> {{\App\Support\Util\NumberUtil::formatPrice($order->shipping_price)}}</div>
                        <div><b>Total:</b> {{\App\Support\Util\NumberUtil::formatPrice($order->final_price + $order->shipping_price)}}</div>
                        <div><b>Status:</b> {{$order->payment_status_label}}</div>
                    </div>
                </div>
            @else
                <h3>Pedido não encontrado.</h3>
            @endif
        </div>
    </div>
@endsection 