@php use Illuminate\Support\Facades\Session; @endphp
<header id="header">
    <div class="alignHeader">
        <a href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Ellon Sports Logo">
        </a>
        <div class="options">
            <a href="/">Brasileiros <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10"
                                         alt="Search Icon"></a>
            <a href="/">Internacionais <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10"
                                            alt="Search Icon"> </a>
            <a href="/">Seleções <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10"
                                      alt="Search Icon"> </a>
        </div>
        <div class="searchGroup">
            <div class="searchInput">
                <input type="text" id="product-search-input" placeholder="Pesquise por algum produto"
                       autocomplete="off">
                <img src="{{ asset('images/icons/search-icon.svg') }}" width="16" height="16" alt="Search Icon"
                     class="searchIcon">
            </div>
            <div id="search-results-dropdown" class="search-results-dropdown" style="display:none;"></div>
        </div>
        <div class="userMenuContainer">
            @auth
                <div class="userMenu">
                    <div class="userMenuTrigger">
                        <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon"
                             class="searchIcon">
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <div class="userMenuDropdown">
                        <a href="/my-account">Minha Conta</a>
                        <a href="/my-orders">Meus Pedidos</a>
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="logout-button">Sair</button>
                        </form>
                    </div>
                </div>
            @else
                <a class="imgIcon" href="{{ route('login') }}">
                    <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon"
                         class="searchIcon">
                    Entrar / Criar conta
                </a>
            @endauth
        </div>
        <a class="imgIcon" href="/cart">
            <img src="{{ asset('images/icons/cart-icon.png') }}" width="20" height="20" alt="Cart Icon"
                 class="searchIcon">
            <p>
                Carrinho
                @php($cart = Session::get('cart'))
                {{$cart && $cart->items->sum('quantity') > 0 ? ('('. $cart->items->sum('quantity') . ')') : ''}}
            </p>
        </a>
    </div>
</header>

<style>
    .userMenu {
        position: relative;
        display: inline-block;
    }

    .userMenuDropdown {
        text-align: end;
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        border-radius: 4px;
        padding: 8px 0;
        min-width: 180px;
        z-index: 1000;
    }

    .userMenuDropdown a {
        display: block;
        padding: 8px 16px;
        margin-right: 0 !important;
        color: #333;
        text-decoration: none;
        transition: background-color 0.2s;
    }

    .userMenuDropdown a:hover {
        background-color: #f5f5f5;
    }

    .userMenu:hover .userMenuDropdown {
        display: block;
    }

    .userMenuTrigger {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .userMenuTrigger span {
        color: #333;
    }

    .logout-button {
        width: 100%;
        text-align: left;
        background: none;
        border: none;
        padding: 8px 16px;
        color: #333;
        cursor: pointer;
        font: inherit;
    }

    .logout-button:hover {
        background-color: #f5f5f5;
    }

    .search-results-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: #fff;
        border: 1px solid #eee;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        z-index: 1001;
        max-height: 400px;
        overflow-y: auto;
        padding: 10px;
    }

    .search-result-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-item img {
        border-radius: 4px;
        background: #f5f5f5;
    }

    .no-results {
        padding: 10px;
        color: #888;
    }

    .searchGroup {
        position: relative;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('product-search-input');
        const dropdown = document.getElementById('search-results-dropdown');
        let timeout = null;

        input.addEventListener('input', function () {
            clearTimeout(timeout);
            const query = this.value.trim();
            if (query.length < 2) {
                dropdown.style.display = 'none';
                dropdown.innerHTML = '';
                return;
            }
            timeout = setTimeout(() => {
                fetch(`/search/products?q=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(products => {
                        if (products.length === 0) {
                            dropdown.innerHTML = '<div class="no-results">Nenhum produto encontrado.</div>';
                        } else {
                            dropdown.innerHTML = products.map(product => `
                            <a class="search-result-item" href="${product.url}">
                                <img src="${product.image ?? '/images/no-image.png'}" alt="${product.name}" width="50" height="70">
                                <div>
                                    <strong>${product.name}</strong><br>
                                    <span>${product.sku ?? ''}</span>
                                </div>
                            </a>
                        `).join('');
                        }
                        dropdown.style.display = 'block';
                    });
            }, 300); // debounce
        });

        // Esconde o dropdown ao clicar fora
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target) && e.target !== input) {
                dropdown.style.display = 'none';
            }
        });
    });
</script>
