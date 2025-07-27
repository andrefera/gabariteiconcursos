@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/order_list.css') !!}">
@section('content')
    <div class="alignSection">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li><a href="#">Início</a></li>
                <li class="active">Minha Conta</li>
            </ol>
        </nav>
    </div>
    <main class="minhaConta">
        <div class="alignSection">
            <div class="container">
                <nav class="sidebar">
                    <ul>
                        <li>
                            <a href="#">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-profile.svg') }}"
                                     alt="Perfil">
                                Minha Conta
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-order.svg') }}"
                                     alt="Pedido">
                                Meus Pedidos
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <img width="24" height="24" src="{{ asset('images/icons/mini-address.svg') }}"
                                     alt="Endereço">
                                Meus Endereços
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img  src="{{ asset('images/icons/mini-data.svg') }}"
                                     alt="Dados">
                                Meus Dados
                            </a>
                        </li>
                    </ul>
                </nav>

                <section class="mainContent">
                    <header class="userGreeting">
                        <div class="group">
                            <div class="profileImage">
                                <img width="56" height="56" src="{{ asset('images/icons/profile-circle.svg') }}" alt="Perfil">
                            </div>
                            <div class="userInfo">
                                <h1>Meus dados</h1>
                                <p>Gerencie suas informações pessoais</p>
                            </div>
                        </div>
                    </header>

                    <div class="meusDados">
                        <div class="card">
                            <form class="dadosForm">
                                <div class="formHeader">
                                    <h2>Informações Pessoais</h2>
                                    <p>Atualize seus dados pessoais abaixo</p>
                                </div>

                                <div class="formGrid">
                                    <div class="inputGroup">
                                        <label for="nome">Nome *</label>
                                        <input type="text" id="nome" placeholder="Digite seu nome" value="Ivana">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="sobrenome">Sobrenome *</label>
                                        <input type="text" id="sobrenome" placeholder="Digite seu sobrenome" value="Manzo">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="tipoCadastro">Cadastrado como: *</label>
                                        <select id="tipoCadastro">
                                            <option selected>Pessoa Física</option>
                                            <option>Pessoa Jurídica</option>
                                        </select>
                                    </div>

                                    <div class="inputGroup">
                                        <label for="cpf">CPF *</label>
                                        <input type="text" id="cpf" placeholder="Digite seu CPF" value="354.301.686-53">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="rg">RG</label>
                                        <input type="text" id="rg" placeholder="Digite seu RG" value="M1396919">
                                    </div>

                                    <div class="inputGroup fullWidth">
                                        <label for="email">E-mail Cadastrado</label>
                                        <input type="email" id="email" placeholder="Digite seu e-mail" value="dede37189@gmail.com" disabled>
                                    </div>
                                </div>

                                <div class="buttonArea">
                                    <button type="submit" class="btnPrimary">
                                        <i class="fas fa-save"></i>
                                        ATUALIZAR DADOS
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        </div>
    </main>
@endsection
