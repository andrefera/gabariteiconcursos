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
<button id="botaoVoltar" class="botaoVoltarTopo">
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

        <form class="formularioCadastro" id="formulario" method="POST">
            @csrf
            <div class="campo visivelSuave" id="grupoNome">
                <label class="labelInput" for="nome">Nome</label>
                <input type="text" id="nome" name="name" placeholder="Seu nome" value="{{ old('name') }}" class="register-field"/>
            </div>
            <div class="campo visivelSuave">
                <label class="labelInput" for="email">E-mail</label>
                <input type="email" id="email" name="email" placeholder="seuemail@empresa.com" value="{{ old('email') }}"/>
            </div>
            <div class="campo visivelSuave">
                <label class="labelInput" for="senha">
                    Senha
                    <a href="#" class="linkRecuperarSenha" id="esqueceuSenha">Esqueceu a senha?</a>
                </label>
                <input type="password" id="senha" name="password" placeholder="mín. 6 caracteres"/>
            </div>
            <div class="campo visivelSuave" id="grupoConfirmaSenha">
                <label class="labelInput" for="confirmaSenha">Confirmar Senha</label>
                <input type="password" id="confirmaSenha" name="password_confirmation" placeholder="Digite sua senha novamente" class="register-field"/>
            </div>
            <div class="aceiteTermos" id="grupoTermos">
                <input type="checkbox" id="termos" class="register-field"/>
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
    document.getElementById('botaoVoltar').onclick = function() {
        if (document.referrer && !document.referrer.endsWith('/')) {
            window.history.back();
        } else {
            window.location.href = '/';
        }
    };

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

    // Hide register-only fields initially
    document.querySelectorAll('.register-field').forEach(field => {
        field.required = modoCadastro;
    });

    function alternarModo(e) {
        e.preventDefault();
        modoCadastro = !modoCadastro;

        [formTitulo, formDescricao, formulario].forEach(el => el.classList.add('fadeOut'));

        setTimeout(() => {
            if (modoCadastro) {
                formTitulo.textContent = 'Comece Agora';
                formDescricao.textContent = 'Crie sua conta e comece a renovar seu guarda-roupa com nossos produtos.';
                rodapeTexto.innerHTML = 'Já tem uma conta? <span id="alternarFormulario">Entrar</span>';
                grupoNome.style.display = 'block';
                grupoConfirmaSenha.style.display = 'block';
                grupoTermos.style.display = 'block';
                esqueceuSenha.style.display = 'none';
                botaoPrincipal.textContent = 'Cadastrar';
            } else {
                formTitulo.textContent = 'Bem-vindo de volta';
                formDescricao.textContent = 'Acesse sua conta para acompanhar pedidos e aproveitar nossas ofertas exclusivas.';
                rodapeTexto.innerHTML = 'Novo por aqui? <span id="alternarFormulario">Criar conta</span>';
                grupoNome.style.display = 'none';
                grupoConfirmaSenha.style.display = 'none';
                grupoTermos.style.display = 'none';
                esqueceuSenha.style.display = 'inline';
                botaoPrincipal.textContent = 'Entrar';
            }

            // Toggle required attribute for register-only fields
            document.querySelectorAll('.register-field').forEach(field => {
                field.required = modoCadastro;
            });

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
            password: document.getElementById('senha').value,
            _token: token
        };

        if (modoCadastro) {
            formData.name = document.getElementById('nome').value;
            formData.password_confirmation = document.getElementById('confirmaSenha').value;

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
        }

        try {
            const response = await fetch(modoCadastro ? '{{ route("register.submit") }}' : '{{ route("login.submit") }}', {
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
