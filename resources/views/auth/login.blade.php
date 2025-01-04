<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Ellon Sports</title>
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

        .login-container {
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
<div class="login-container">
    <div class="logo">
        <img src="{{ asset('images/name_logo.png') }}" alt="Ellon Sports Logo">
    </div>
    <form action="{{ route('auth.login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua senha"
                   required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
    </form>
    <div class="text-center mt-3">
        <a href="{{ route('register') }}">Não tem uma conta? Cadastre-se</a>
    </div>
</div>
</body>
</html>
