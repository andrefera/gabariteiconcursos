@extends('layouts.app')
@section('title', 'Gabaritei Concursos')
@section('head_content')
<link rel="stylesheet" href="{!! asset('assets/css/home.css') !!}">
<link rel="stylesheet" href="{!! asset('assets/css/list.css') !!}">
@endsection
@section('content')
<section class="listNavbar" aria-labelledby="page-title">
  <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ url('/') }}" class="breadcrumbLink">Início</a>
      <span class="breadcrumbSep"><img src="{{ asset('images/breadcrumb.svg') }}" alt=""></span>
      <span class="breadcrumbCurrent">Receita Federal</span>
  </nav>
</section>
<section class="listHero" aria-labelledby="page-title">
  <div class="container">
    <h1 id="page-title" class="listTitle">Concurso Receita Federal</h1>
    <p class="listSubtitle">
      Materiais completos para os concursos da Receita Federal, com apostilas e livros atualizados
      conforme o edital, focados nos conteúdos mais cobrados para os cargos da área fiscal.
    </p>
  </div>
</section>
<section class="launchSection">
  <div class="sectionInner">
      <div class="listControls">
          <input type="search" class="listSearch" placeholder="Buscar produtos..." aria-label="Buscar produtos">
          <div class="listActions">
              <button type="button" class="btn btnSort">Ordenar</button>
              <button type="button" class="btn btnFilter">Filtrar</button>
          </div>
      </div>
      <div class="productGrid">
          @php
              $items = $products ?? range(1,12);
          @endphp

          @foreach($items as $i)
              <article class="productCard">
                  <div class="productImageWrapper">
                      <img src="{{ asset('images/banner.png') }}" alt="Apostila Banco do Brasil - Escriturário e Agente Comercial">
                  </div>
                  <div class="productInfo">
                      <span class="productBadge">
                          <img class="productBadgeIcon" src="{{ asset('images/icons/transporte.svg') }}" alt="">
                          Frete grátis
                      </span>
                      <p class="productName">Apostila Banco do Brasil - Escriturário e Agente Comercial</p>
                      <div class="productPriceGroup">
                          <span class="productOldPrice">de R$ 149,00</span>
                          <span class="productPrice">R$ 34,88</span>
                          <span class="productInstallment">ou 3X de R$ 23 sem juros</span>
                      </div>
                  </div>
              </article>
          @endforeach
      </div>
      {{-- include pagination --}}
      @include('components.pagination')
  </div>
</section>
@endsection
@section('footer_content')
@endsection
