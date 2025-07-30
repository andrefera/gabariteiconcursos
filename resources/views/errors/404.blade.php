@extends('layouts.app')
@section('title', 'Página não encontrada | Ellon Sports')
@section('head_content')
    <link rel="stylesheet" href="{!! asset('assets/css/404.css') !!}">
@endsection
@section('content')
<div class="error-404-container" style="text-align:center; padding: 60px 20px; min-height: 60vh; display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <img src="{{ asset('images/logo.png') }}" alt="Ellon Sports Logo" style="max-width: 180px; margin-bottom: 32px;">
    <h1 style="font-size: 4rem; color: #FF7C00; font-weight: 900; margin-bottom: 16px;">404</h1>
    <h2 style="font-size: 2rem; color: #222; font-weight: 700; margin-bottom: 12px;">Página não encontrada</h2>
    <p style="font-size: 1.2rem; color: #555; margin-bottom: 32px;">A página que você procura não existe ou foi removida.</p>
    <a href="/" style="background: #FF7C00; color: #fff; padding: 12px 32px; border-radius: 6px; font-weight: 700; text-decoration: none; font-size: 1.1rem; transition: background 0.2s;">Voltar para a Home</a>
</div>
@endsection 