<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ellon Sports</title>
    <style>
        /* Paleta de cores */
        :root {
            --primary-color: #ffffff;
            --secondary-color: #000000;
            --accent-color: #e85e08;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .topbar {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar .logo {
            display: flex;
            align-items: center;
        }

        .topbar img {
            max-height: 50px;
            margin-right: 10px;
        }

        .topbar nav a {
            color: var(--secondary-color);
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
        }

        .topbar nav a:hover {
            text-decoration: underline;
            color:  var(--accent-color);
        }

        .hero-section {
            text-align: center;
            padding: 60px 20px;
            background-color: var(--primary-color);
            color: var(--secondary-color);
        }

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn-custom {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            padding: 10px 20px;
            border: 2px solid var(--secondary-color);
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .btn-custom:hover {
            background-color: var(--accent-color);
            color: var(--secondary-color);
            border-color: var(--accent-color);
        }
    </style>
</head>
<body>

<header class="topbar">
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Ellon Sports Logo">
    </div>
    <nav>
        <a href="/login">Entrar</a>
        <a href="/register">Cadastrar</a>
    </nav>
</header>

<section class="hero-section">
    <h1>Bem-vindo à Ellon Sports</h1>
    <a href="/" class="btn btn-custom">Visite nossa loja</a>
</section>
</body>
</html>
