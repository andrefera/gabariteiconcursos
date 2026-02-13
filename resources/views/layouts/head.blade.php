<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <!-- Montserrat (400, 500, 600, 800) + Sora (400, 600, 700, 800) -->
    <link rel="preload"
          href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;800&family=Sora:wght@400;600;700;800&display=swap"
          as="style">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;800&family=Sora:wght@400;600;700;800&display=swap"
          media="print"
          onload="this.media='all'">
    <noscript>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;800&family=Sora:wght@400;600;700;800&display=swap">
    </noscript>

    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{!! asset('assets/css/header.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/footer.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/main.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/toast.css') !!}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="google-site-verification" content="C0HJHweuVVHAhd7on5pa65Du-BmV0n8iNeTju6SFy5c">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="theme-color" content="#076035">
    <meta name="robots" content="index, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta-tags')
    @yield('head_content')
    <title>@yield('title')</title>
    <script type="application/ld+json">
        {
           "@context": "https://schema.org",
           "@type": "Organization",
           "name": "Gabaritei Concursos",
           "url": "{{ config('app.url') }}",
        {{--        "logo": "{{ asset_cdn('assets/img/logo.svg') }}",--}}
        "sameAs": [
          "https://www.instagram.com/novaconcursos/",
          "https://www.facebook.com/NOVAConcursosOficial/",
          "https://www.youtube.com/user/GrupoNovaConcursos/",
          "https://www.tiktok.com/@novaconcursos/"
        ],
        "contactPoint": {
           "@type": "ContactPoint",
           "telephone": "+55-35-997648167",
           "contactType": "Customer Service",
           "areaServed": "BR",
           "availableLanguage": ["Portuguese"]
        },
        "address": {
           "@type": "PostalAddress",
           "streetAddress": "Rua Americo Totti, 110",
           "addressLocality": "Minas Gerais",
           "addressRegion": "MG",
           "postalCode": "37130-000",
           "addressCountry": "BR"
        }
    }
    </script>
    <script src="{{ asset('assets/js/header.min.js') }}?v={{ config('app.static_version') }}" defer></script>
    <script src="{{ asset('assets/js/toast.js') }}?v={{ config('app.static_version') }}" defer></script>
</head>
