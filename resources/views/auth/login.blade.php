<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Entrar / Criar Conta - Ellon Sports</title>
    <link rel="stylesheet" href="{!! asset('assets/css/auth.css') !!}">
</head>
<body>
<button id="botaoVoltar" class="botaoVoltarTopo">
    ⬅ Voltar
</button>

<div class="containerPrincipal">
    <div class="areaFormulario">
        <div class="logoEmpresa">
            <img src="{{ asset('images/mini_logo.png') }}" width="60" height="56" alt="Ellon Sports Logo">
        </div>
        
        <!-- Tela de seleção inicial -->
        <div id="telaSelecao" class="tela-selecao">
            <h1 class="tituloFormulario">Bem-vindo!</h1>
            <p class="descricaoFormulario">Escolha uma opção para continuar</p>
            
            <div class="botoesSelecao">
                <button class="botaoSelecao" id="botaoNovo">
                    <div class="icone-botao">👤</div>
                    <div class="texto-botao">
                        <h3>Sou novo</h3>
                        <p>Criar uma nova conta</p>
                    </div>
                </button>
                
                <button class="botaoSelecao" id="botaoExistente">
                    <div class="icone-botao">🔑</div>
                    <div class="texto-botao">
                        <h3>Já tenho conta</h3>
                        <p>Fazer login</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- Formulário de Registro -->
        <div id="formularioRegistro" class="formulario-container oculto">
            <h1 class="tituloFormulario">Criar Conta</h1>
            <p class="descricaoFormulario">Crie sua conta e comece a renovar seu guarda-roupa com nossos produtos.</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="formularioCadastro" id="formularioRegistroForm" method="POST">
                @csrf
                <div class="campo">
                    <label class="labelInput" for="nome">Nome</label>
                    <input type="text" id="nome" name="name" placeholder="Seu nome" value="{{ old('name') }}" required/>
                </div>
                <div class="campo">
                    <label class="labelInput" for="emailRegistro">E-mail</label>
                    <input type="email" id="emailRegistro" name="email" placeholder="seuemail@empresa.com" value="{{ old('email') }}" required/>
                </div>
                <div class="campo">
                    <label class="labelInput" for="senhaRegistro">Senha</label>
                    <input type="password" id="senhaRegistro" name="password" placeholder="mín. 6 caracteres" required/>
                </div>
                <div class="campo">
                    <label class="labelInput" for="confirmaSenhaRegistro">Confirmar Senha</label>
                    <input type="password" id="confirmaSenhaRegistro" name="password_confirmation" placeholder="Digite sua senha novamente" required/>
                </div>
                <div class="aceiteTermos">
                    <input type="checkbox" id="termos" required/>
                    <label for="termos">Concordo com os <a href="#">Termos & Privacidade</a></label>
                </div>

                <button type="submit" class="botaoLogin">Criar Conta</button>
            </form>

            <p class="textoRodape">
                Já tem uma conta? <span id="voltarLogin">Fazer login</span>
            </p>
        </div>

        <!-- Formulário de Login -->
        <div id="formularioLogin" class="formulario-container oculto">
            <h1 class="tituloFormulario">Fazer Login</h1>
            <p class="descricaoFormulario">Acesse sua conta para acompanhar pedidos e aproveitar nossas ofertas exclusivas.</p>

            <form class="formularioCadastro" id="formularioLoginForm" method="POST">
                @csrf
                <div class="campo">
                    <label class="labelInput" for="emailLogin">E-mail</label>
                    <input type="email" id="emailLogin" name="email" placeholder="seuemail@empresa.com" value="{{ old('email') }}" required/>
                </div>
                <div class="campo">
                    <label class="labelInput" for="senhaLogin">
                        Senha
                        <a href="#" class="linkRecuperarSenha">Esqueceu a senha?</a>
                    </label>
                    <input type="password" id="senhaLogin" name="password" placeholder="Digite sua senha" required/>
                </div>

                <button type="submit" class="botaoLogin">Entrar</button>
            </form>

            <p class="textoRodape">
                Novo por aqui? <span id="voltarRegistro">Criar conta</span>
            </p>
        </div>
    </div>
</div>

<script>
    document.getElementById('botaoVoltar').onclick = function() {
        if (document.referrer && !document.referrer.endsWith('/')) {
            window.history.back();
        } else {
            window.location.href = '/';
        }
    };

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Elementos da interface
    const telaSelecao = document.getElementById('telaSelecao');
    const formularioRegistro = document.getElementById('formularioRegistro');
    const formularioLogin = document.getElementById('formularioLogin');
    
    // Botões de seleção
    const botaoNovo = document.getElementById('botaoNovo');
    const botaoExistente = document.getElementById('botaoExistente');
    
    // Botões de navegação entre formulários
    const voltarLogin = document.getElementById('voltarLogin');
    const voltarRegistro = document.getElementById('voltarRegistro');
    
    // Formulários
    const formRegistro = document.getElementById('formularioRegistroForm');
    const formLogin = document.getElementById('formularioLoginForm');

    // Função para mostrar tela de seleção
    function mostrarTelaSelecao() {
        telaSelecao.classList.remove('oculto');
        formularioRegistro.classList.add('oculto');
        formularioLogin.classList.add('oculto');
    }

    // Função para mostrar formulário de registro
    function mostrarFormularioRegistro() {
        telaSelecao.classList.add('oculto');
        formularioRegistro.classList.remove('oculto');
        formularioLogin.classList.add('oculto');
    }

    // Função para mostrar formulário de login
    function mostrarFormularioLogin() {
        telaSelecao.classList.add('oculto');
        formularioRegistro.classList.add('oculto');
        formularioLogin.classList.remove('oculto');
    }

    // Event listeners para botões de seleção
    botaoNovo.addEventListener('click', mostrarFormularioRegistro);
    botaoExistente.addEventListener('click', mostrarFormularioLogin);

    // Event listeners para navegação entre formulários
    voltarLogin.addEventListener('click', mostrarFormularioLogin);
    voltarRegistro.addEventListener('click', mostrarFormularioRegistro);

    // Validação do formulário de registro
    formRegistro.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            name: document.getElementById('nome').value,
            email: document.getElementById('emailRegistro').value,
            password: document.getElementById('senhaRegistro').value,
            password_confirmation: document.getElementById('confirmaSenhaRegistro').value,
            _token: token
        };

        // Validações
        if (!document.getElementById('termos').checked) {
            alert('Por favor, aceite os termos e condições para continuar.');
            return;
        }

        if (!formData.password || formData.password.length < 6) {
            alert('A senha precisa ter no mínimo 6 caracteres.');
            return;
        }

        if (formData.password !== formData.password_confirmation) {
            alert('As senhas não coincidem. Por favor, verifique.');
            return;
        }

        try {
            const response = await fetch('{{ route("register.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(formData)
            });

            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            const data = await response.json();

            if (data.success) {
                window.location.href = '/';
            } else {
                alert(data.message || 'Erro ao criar conta.');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao processar sua solicitação. Tente novamente mais tarde.');
        }
    });

    // Validação do formulário de login
    formLogin.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = {
            email: document.getElementById('emailLogin').value,
            password: document.getElementById('senhaLogin').value,
            _token: token
        };

        try {
            const response = await fetch('{{ route("login.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(formData)
            });

            if (response.redirected) {
                window.location.href = response.url;
                return;
            }

            const data = await response.json();

            if (data.success) {
                window.location.href = '/';
            } else {
                alert(data.message || 'Erro ao fazer login. Verifique suas credenciais.');
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao processar sua solicitação. Tente novamente mais tarde.');
        }
    });
</script>
</body>
</html>
