<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Cadastro - Gestão de Equipe</title>
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

        <form class="formularioCadastro" id="formulario">
            <div class="campo visivelSuave" id="grupoNome">
                <label class="labelInput" for="nome">Nome</label>
                <input type="text" id="nome" placeholder="Seu nome"/>
            </div>
            <div class="campo visivelSuave" id="grupoNome">
                <label class="labelInput" for="email">E-mail</label>
                <input type="email" id="email" placeholder="seuemail@empresa.com"/>
            </div>
            <div class="campo visivelSuave" id="grupoNome">
                <label class="labelInput" for="senha">
                    Senha
                    <a href="#" class="linkRecuperarSenha">Esqueceu a senha?</a>
                </label>
                <input type="password" id="senha" placeholder="mín. 8 caracteres"/>
            </div>
            <div class="aceiteTermos" id="grupoTermos">
                <input type="checkbox" id="termos"/>
                <label for="termos">Concordo com os <a href="#">Termos & Privacidade</a></label>
            </div>

            <button type="submit" class="botaoLogin" id="botaoPrincipal">Entrar</button>
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
</body>
</html>
<script>
    const alternarLink = document.getElementById('alternarFormulario');
    const formTitulo = document.getElementById('formTitulo');
    const formDescricao = document.getElementById('formDescricao');
    const formulario = document.getElementById('formulario');
    const rodapeTexto = document.getElementById('rodapeTexto');

    const grupoNome = document.getElementById('grupoNome');
    const grupoTermos = document.getElementById('grupoTermos');
    const botaoPrincipal = document.getElementById('botaoPrincipal');

    let modoCadastro = true;

    function alternarModo(e) {
        e.preventDefault();
        modoCadastro = !modoCadastro;

        [formTitulo, formDescricao, formulario].forEach(el => el.classList.add('fadeOut'));

        setTimeout(() => {
            if (modoCadastro) {
                formTitulo.textContent = 'Comece Agora';
                formDescricao.textContent = 'Crie sua conta e comece a renovar seu guarda-roupa com nossos produtos.';
                rodapeTexto.innerHTML = 'Já tem uma conta? <span id="alternarFormulario">Entrar</span>';
                grupoNome.classList.remove('ocultoSuave');
                grupoNome.classList.add('visivelSuave');
                grupoTermos.classList.remove('ocultoSuave');
                grupoTermos.classList.add('visivelSuave');
                botaoPrincipal.textContent = 'Cadastrar';
            } else {
                formTitulo.textContent = 'Bem-vindo de volta';
                formDescricao.textContent = 'Acesse sua conta para acompanhar pedidos e aproveitar nossas ofertas exclusivas.';
                rodapeTexto.innerHTML = 'Novo por aqui? <span id="alternarFormulario">Criar conta</span>';
                grupoNome.classList.remove('visivelSuave');
                grupoNome.classList.add('ocultoSuave');
                grupoTermos.classList.remove('visivelSuave');
                grupoTermos.classList.add('ocultoSuave');
                botaoPrincipal.textContent = 'Entrar';
            }

            [formTitulo, formDescricao, formulario].forEach(el => {
                el.classList.remove('fadeOut');
                el.classList.add('fadeIn');
            });

            document.getElementById('alternarFormulario').addEventListener('click', alternarModo);
        }, 300);
    }


    alternarLink.addEventListener('click', alternarModo);
</script>
