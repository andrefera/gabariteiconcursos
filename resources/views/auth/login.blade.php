<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Gestão de Equipe</title>
    <link rel="stylesheet" href="{!! asset('assets/css/login.css') !!}">
</head>
<body>
<button onclick="window.scrollTo({ top: 0, behavior: 'smooth' });" class="botaoVoltarTopo">
    ⬅ Voltar
</button>

<div class="containerPrincipal">
    <div class="areaFormulario">
        <div class="logoEmpresa">
            <img src="{{ asset('images/mini_logo.png') }}" width="60" height="56" alt="Ellon Sports Logo">
        </div>
        <h1 class="tituloFormulario" id="formTitulo">Comece Agora</h1>
        <p class="descricaoFormulario" id="formDescricao">Crie sua conta e comece a renovar seu guarda-roupa com nossos produtos.</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="botoesSociais">
            <button class="botaoSocial google">
                <img src="{{ asset('images/google.png') }}" width="20" height="20" alt="Ellon Sports Logo">
                Entrar com Google
            </button>
            <button class="botaoSocial facebook">
                <img src="{{ asset('images/facebook.png') }}" width="20" height="20" alt="Ellon Sports Logo">
                Entrar com Facebook
            </button>
        </div>

        <div class="linhaSeparadora">
            <span class="textoSeparador">ou</span>
        </div>

        <form class="formularioCadastro" id="formulario" method="POST">
            @csrf
            <div class="campo visivelSuave" id="grupoNome">
                <label class="labelInput" for="nome">Nome</label>
                <input type="text" id="nome" name="name" placeholder="Seu nome" required="required" data-register-only="true" value="{{ old('name') }}"/>
            </div>
            <div class="campo visivelSuave">
                <label class="labelInput" for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="seuemail@empresa.com" required value="{{ old('email') }}"/>
            </div>
            <div class="campo visivelSuave">
                <label class="labelInput" for="senha">
                    Senha
                    <a href="#" class="linkRecuperarSenha" id="esqueceuSenha">Esqueceu a senha?</a>
                </label>
                <input type="password" id="senha" name="password" placeholder="mín. 8 caracteres" required/>
            </div>
            <div class="campo visivelSuave" id="grupoConfirmaSenha">
                <label class="labelInput" for="confirmaSenha">Confirmar Senha</label>
                <input type="password" id="confirmaSenha" name="password_confirmation" placeholder="Digite sua senha novamente" required data-register-only="true"/>
            </div>
            <div class="aceiteTermos" id="grupoTermos">
                <input type="checkbox" id="termos" required data-register-only="true"/>
                <label for="termos">Concordo com os <a href="#">Termos & Privacidade</a></label>
            </div>

            <button type="submit" class="botaoLogin" id="botaoPrincipal">Cadastrar</button>
        </form>

        <p class="textoRodape" id="rodapeTexto">
            Já tem uma conta? <span id="alternarFormulario">Entrar</span>
        </p>
    </div>

    <div class="areaIlustracao">
        <div class="area">

        </div>
    </div>
</div>

<script>
    const alternarLink = document.getElementById('alternarFormulario');
    const formTitulo = document.getElementById('formTitulo');
    const formDescricao = document.getElementById('formDescricao');
    const formulario = document.getElementById('formulario');
    const rodapeTexto = document.getElementById('rodapeTexto');
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const grupoNome = document.getElementById('grupoNome');
    const grupoConfirmaSenha = document.getElementById('grupoConfirmaSenha');
    const grupoTermos = document.getElementById('grupoTermos');
    const botaoPrincipal = document.getElementById('botaoPrincipal');
    const esqueceuSenha = document.getElementById('esqueceuSenha');

    let modoCadastro = true;

    function alternarModo(e) {
        e.preventDefault();
        modoCadastro = !modoCadastro;

        [formTitulo, formDescricao, formulario].forEach(el => el.classList.add('fadeOut'));

        // Get all inputs that are register-only
        const registerOnlyInputs = document.querySelectorAll('[data-register-only="true"]');

        setTimeout(() => {
            if (modoCadastro) {
                formTitulo.textContent = 'Comece Agora';
                formDescricao.textContent = 'Crie sua conta e comece a renovar seu guarda-roupa com nossos produtos.';
                rodapeTexto.innerHTML = 'Já tem uma conta? <span id="alternarFormulario">Entrar</span>';
                grupoNome.classList.remove('ocultoSuave');
                grupoNome.classList.add('visivelSuave');
                grupoConfirmaSenha.classList.remove('ocultoSuave');
                grupoConfirmaSenha.classList.add('visivelSuave');
                grupoTermos.classList.remove('ocultoSuave');
                grupoTermos.classList.add('visivelSuave');
                esqueceuSenha.style.display = 'none';
                botaoPrincipal.textContent = 'Cadastrar';
                // Make register-only fields required
                registerOnlyInputs.forEach(input => input.required = true);
            } else {
                formTitulo.textContent = 'Bem-vindo de volta';
                formDescricao.textContent = 'Acesse sua conta para acompanhar pedidos e aproveitar nossas ofertas exclusivas.';
                rodapeTexto.innerHTML = 'Novo por aqui? <span id="alternarFormulario">Criar conta</span>';
                grupoNome.classList.remove('visivelSuave');
                grupoNome.classList.add('ocultoSuave');
                grupoConfirmaSenha.classList.remove('visivelSuave');
                grupoConfirmaSenha.classList.add('ocultoSuave');
                grupoTermos.classList.remove('visivelSuave');
                grupoTermos.classList.add('ocultoSuave');
                esqueceuSenha.style.display = 'inline';
                botaoPrincipal.textContent = 'Entrar';
                // Remove required from register-only fields
                registerOnlyInputs.forEach(input => input.required = false);
            }

            [formTitulo, formDescricao, formulario].forEach(el => {
                el.classList.remove('fadeOut');
                el.classList.add('fadeIn');
            });

            document.getElementById('alternarFormulario').addEventListener('click', alternarModo);
        }, 300);
    }

    alternarLink.addEventListener('click', alternarModo);

    // Handle form submission
    formulario.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = {
            email: document.getElementById('email').value,
            password: document.getElementById('senha').value
        };

        if (modoCadastro) {
            formData.name = document.getElementById('nome').value;
            formData.password_confirmation = document.getElementById('confirmaSenha').value;

            // Validate if passwords match
            if (formData.password !== formData.password_confirmation) {
                alert('As senhas não coincidem. Por favor, verifique.');
                return;
            }
        }

        const url = modoCadastro ? '{{ route("auth.register") }}' : '{{ route("auth.login") }}';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (data.success) {
                // Save JWT token in localStorage
                if (data.token) {
                    localStorage.setItem('jwt_token', data.token);
                }
                window.location.href = '/';
            } else {
                alert(data.message || (modoCadastro ? 'Erro ao criar conta.' : 'Erro ao fazer login. Verifique suas credenciais.'));
            }
        } catch (error) {
            console.error('Erro:', error);
            alert('Erro ao processar sua solicitação. Tente novamente mais tarde.');
        }
    });
</script>
</body>
</html>
