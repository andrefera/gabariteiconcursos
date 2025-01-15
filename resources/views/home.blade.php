@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/home.css') !!}">
@section('content')
    <div class="banner">
        <img src="{{ asset('images/banner.jpg') }}" alt="Ellon Sports Banner">
    </div>


    <section class="teamSection">
        <div class="alignSection">
            <div class="teamGroup">
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/botafogo.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/atletico.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/cruzeiro.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/corinthians.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/flamengo.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/palmeiras.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/vasco.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/saopaulo.png') }}" alt="Ellon Sports Banner">
                </a>
                <a href="/" class="team">
                    <img src="{{ asset('images/teams/fluminense.png') }}" alt="Ellon Sports Banner">
                </a>
            </div>
        </div>
    </section>
@endsection
