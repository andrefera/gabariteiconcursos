<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Ellon Sports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e85e08;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .register-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .logo {
            display: flex;
            justify-content: center;
        }
        .logo img {
            width: 250px;
            margin-bottom: 20px;
        }

        .btn-primary {
            background-color: #e85e08;
            border: none;
        }
        .btn-primary:hover {
            background-color: #d35400;
        }
        .text-center a {
            color: #e85e08;
            text-decoration: none;
        }
        .text-center a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="register-container">
    <div class="logo">
        <img src="{{ asset('images/name_logo.png') }}" alt="Ellon Sports Logo">
    </div>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha" required>
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirme a Senha</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme sua senha" required>
        </div>
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="termos" required>
                <label class="form-check-label" for="termos">
                    Concordo com os <a href="{{ route('terms.use') }}" target="_blank">Termos de Uso</a> e <a href="{{ route('privacy.policy') }}" target="_blank">Política de Privacidade</a>
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrar</button>
    </form>
    <div class="text-center mt-3">
        <a href="{{ route('login') }}">Já tem uma conta? Faça login</a>
    </div>
</div>
</body>
</html>
