@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/home.css') !!}">
@section('content')
    <div class="banner">
        <img src="{{ asset('images/banner2.jpg') }}" alt="Ellon Sports Banner">
    </div>

<header class="topbar">
    <nav>
        <a href="/login">Entrar</a>
        <a href="/register">Cadastrar</a>
    </nav>
</header>

<section class="hero-section">
    <h1>Bem-vindo à Ellon Sports</h1>
    <a href="/" class="btn btn-custom">Visite nossa loja</a>
</section>
@endsection
