@extends('layouts.app')
@section('title', 'Ellon Sports | Para Torcedores Apaixonados')
<link rel="stylesheet" href="{!! asset('assets/css/order_list.css') !!}">
<style>
    .inputGroup input.error {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .inputGroup input.error:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
</style>
@push('scripts')
<script src="https://unpkg.com/imask"></script>
<script src="{!! asset('assets/js/data-form.js') !!}"></script>
@endpush
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
                        @if(session('success'))
                            <div class="alert alert-success" style="margin-bottom: 1rem; padding: 1rem; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px;">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger" style="margin-bottom: 1rem; padding: 1rem; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px;">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger" style="margin-bottom: 1rem; padding: 1rem; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px;">
                                <ul style="margin: 0; padding-left: 1rem;">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="card">
                            <form class="dadosForm" method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                <div class="formHeader">
                                    <h2>Informações Pessoais</h2>
                                    <p>Atualize seus dados pessoais abaixo</p>
                                </div>

                                <div class="formGrid">
                                    <div class="inputGroup">
                                        <label for="nome">Nome *</label>
                                        <input type="text" id="nome" name="name" placeholder="Digite seu nome" value="{{ $user['name'] ?? '' }}">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="cpf">CPF *</label>
                                        <input type="text" id="cpf" name="document" placeholder="Digite seu CPF" value="{{ $user['document'] ?? '' }}">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="email">E-mail Cadastrado</label>
                                        <input type="email" id="email" placeholder="Digite seu e-mail" value="{{ $user['email'] ?? '' }}" disabled>
                                    </div>

                                    <div class="inputGroup">
                                        <label for="phone">Telefone</label>
                                        <input type="text" id="phone" name="phone" placeholder="(00) 00000-0000" value="{{ $user['phone'] ?? '' }}">
                                    </div>
                                </div>

                                <div class="formHeader" style="margin-top: 2rem;">
                                    <h2>Endereço de Cobrança</h2>
                                    <p>Informe o endereço para cobrança</p>
                                </div>

                                <div class="formGrid">
                                    @php
                                        $address = !empty($addresses) ? $addresses[0] : null;
                                        $userState = $user['state'] ?? '';
                                        $userZipCode = $user['zip_code'] ?? '';
                                        $userStreet = $user['street_name'] ?? '';
                                        $userNumber = $user['street_number'] ?? '';
                                        $userComplement = $user['street_complement'] ?? '';
                                        $userNeighborhood = $user['street_neighborhood'] ?? '';
                                        $userCity = $user['city'] ?? '';
                                    @endphp
                                    
                                    <div class="inputGroup fullWidth">
                                        <label for="cep">CEP</label>
                                        <input type="text" id="cep" name="zip_code" placeholder="00000-000" value="{{ $address['zipcode'] ?? $userZipCode }}">
                                    </div>

                                    <div class="inputGroup fullWidth">
                                        <label for="rua">Rua</label>
                                        <input type="text" id="rua" name="street" placeholder="Digite o nome da rua" value="{{ $address['street'] ?? $userStreet }}">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="numero">Número</label>
                                        <input type="text" id="numero" name="number" placeholder="Número" value="{{ $address['number'] ?? $userNumber }}">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" id="complemento" name="complement" placeholder="Complemento" value="{{ $address['complement'] ?? $userComplement }}">
                                    </div>

                                    <div class="inputGroup fullWidth">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" id="bairro" name="neighborhood" placeholder="Digite o bairro" value="{{ $address['neighborhood'] ?? $userNeighborhood }}">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" id="cidade" name="city" placeholder="Digite a cidade" value="{{ $address['city'] ?? $userCity }}">
                                    </div>

                                    <div class="inputGroup">
                                        <label for="estado">Estado</label>
                                        <select id="estado" name="state">
                                            <option value="">Selecione o estado</option>
                                            <option value="AC" {{ ($address['state'] ?? $userState) == 'AC' ? 'selected' : '' }}>Acre</option>
                                            <option value="AL" {{ ($address['state'] ?? $userState) == 'AL' ? 'selected' : '' }}>Alagoas</option>
                                            <option value="AP" {{ ($address['state'] ?? $userState) == 'AP' ? 'selected' : '' }}>Amapá</option>
                                            <option value="AM" {{ ($address['state'] ?? $userState) == 'AM' ? 'selected' : '' }}>Amazonas</option>
                                            <option value="BA" {{ ($address['state'] ?? $userState) == 'BA' ? 'selected' : '' }}>Bahia</option>
                                            <option value="CE" {{ ($address['state'] ?? $userState) == 'CE' ? 'selected' : '' }}>Ceará</option>
                                            <option value="DF" {{ ($address['state'] ?? $userState) == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                                            <option value="ES" {{ ($address['state'] ?? $userState) == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                                            <option value="GO" {{ ($address['state'] ?? $userState) == 'GO' ? 'selected' : '' }}>Goiás</option>
                                            <option value="MA" {{ ($address['state'] ?? $userState) == 'MA' ? 'selected' : '' }}>Maranhão</option>
                                            <option value="MT" {{ ($address['state'] ?? $userState) == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                                            <option value="MS" {{ ($address['state'] ?? $userState) == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                                            <option value="MG" {{ ($address['state'] ?? $userState) == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                                            <option value="PA" {{ ($address['state'] ?? $userState) == 'PA' ? 'selected' : '' }}>Pará</option>
                                            <option value="PB" {{ ($address['state'] ?? $userState) == 'PB' ? 'selected' : '' }}>Paraíba</option>
                                            <option value="PR" {{ ($address['state'] ?? $userState) == 'PR' ? 'selected' : '' }}>Paraná</option>
                                            <option value="PE" {{ ($address['state'] ?? $userState) == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                                            <option value="PI" {{ ($address['state'] ?? $userState) == 'PI' ? 'selected' : '' }}>Piauí</option>
                                            <option value="RJ" {{ ($address['state'] ?? $userState) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                                            <option value="RN" {{ ($address['state'] ?? $userState) == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                                            <option value="RS" {{ ($address['state'] ?? $userState) == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                                            <option value="RO" {{ ($address['state'] ?? $userState) == 'RO' ? 'selected' : '' }}>Rondônia</option>
                                            <option value="RR" {{ ($address['state'] ?? $userState) == 'RR' ? 'selected' : '' }}>Roraima</option>
                                            <option value="SC" {{ ($address['state'] ?? $userState) == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                                            <option value="SP" {{ ($address['state'] ?? $userState) == 'SP' ? 'selected' : '' }}>São Paulo</option>
                                            <option value="SE" {{ ($address['state'] ?? $userState) == 'SE' ? 'selected' : '' }}>Sergipe</option>
                                            <option value="TO" {{ ($address['state'] ?? $userState) == 'TO' ? 'selected' : '' }}>Tocantins</option>
                                        </select>
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
