@php use Illuminate\Support\Facades\Session; @endphp

<header class="headerContainer">
    <div class="headerTopRow">
        <a class="headerLogoLink" href="{{ url('/') }}" aria-label="Gabaritei Concursos">
            <img class="headerLogoImage" src="{{ asset('images/logo.svg') }}" alt="Gabaritei Concursos">
        </a>

        <button class="headerMenuButton" type="button" aria-label="Abrir menu">
            <span class="headerMenuIcon" aria-hidden="true">
                <img class="headerIconImage" src="{{ asset('images/icons/hambuger_menu.svg') }}" alt="">
            </span>
        </button>

        <div class="headerSearch">
            <span class="headerSearchIcon" aria-hidden="true">
                <img class="headerIconImage" src="{{ asset('images/icons/search.svg') }}" alt="">
            </span>
            <input class="headerSearchInput" type="search" placeholder="O que você procura?" aria-label="Buscar produtos">
        </div>

        <div class="headerActions">
            <a class="headerCartLink" href="#" aria-label="Meu carrinho">
                <span class="headerActionIcon" aria-hidden="true">
                    <img class="headerIconImage" src="{{ asset('images/icons/cart.svg') }}" alt="">
                </span>
                <span class="headerActionText">Meu carrinho</span>
            </a>
            <a class="headerLoginLink" href="#" aria-label="Entrar">
                <span class="headerActionIcon" aria-hidden="true">
                    <img class="headerIconImage" src="{{ asset('images/icons/arrow_bar.svg') }}" alt="">
                </span>
                <span class="headerActionText">Entrar</span>
            </a>
        </div>
    </div>

    <nav class="headerNav">
        <a class="headerCategoryLink" href="#">
            <span class="headerCategoryIcon" aria-hidden="true">
                <img class="headerIconImage" src="{{ asset('images/icons/hambuger_menu.svg') }}" alt="">
            </span>
            <span class="headerCategoryText">Todas as categorias</span>
        </a>
        <a class="headerNavLink" href="#">Concurso Banco do Brasil</a>
        <a class="headerNavLink" href="#">Concurso IBGE</a>
        <a class="headerNavLink" href="#">Apostilas</a>
        <a class="headerNavLink" href="#">Cursos</a>
        <a class="headerNavLink" href="#">Questões</a>
        <a class="headerNavLink" href="#">Combos</a>
        <a class="headerNavLink" href="#">Blog</a>
        <a class="headerNavLink" href="#">Contato</a>
    </nav>
</header>
