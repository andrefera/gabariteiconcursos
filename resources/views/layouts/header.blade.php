@php use Illuminate\Support\Facades\Session; @endphp
<header id="header">
    <div class="alignHeader">
        <div class="mobile-header-actions">   
            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" id="mobile-menu-btn" aria-label="Abrir Menu">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

            <a href="/" class="logo-link">
                <img src="{{ asset('images/logo.png') }}" alt="Ellon Sports Logo">
            </a>
        </div>

         <!-- Mobile Actions -->
         <div class="header-actions mobileOptions">
            <div class="userMenuContainer">
                @auth
                    <div class="userMenu">
                        <div class="userMenuTrigger">
                            <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon" class="searchIcon">
                                <span class="desktop-only">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="userMenuDropdown">
                            <a href="/minha-conta">Minha Conta</a>
                            <a href="/meus-pedidos">Meus Pedidos</a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-button">Sair</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a class="imgIcon" href="{{ route('login') }}">
                        <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon" class="searchIcon">
                            <span class="desktop-only">Entrar / Criar conta</span>
                    </a>
                @endauth
            </div>
                <a class="imgIcon cart-link" href="/carrinho">
                <img src="{{ asset('images/icons/cart-icon.png') }}" width="20" height="20" alt="Cart Icon" class="searchIcon">
                    <span class="desktop-only">
                        Carrinho
                        @php($cart = Session::get('cart'))
                        {{$cart && $cart->items->sum('quantity') > 0 ? ('('. $cart->items->sum('quantity') . ')') : ''}}
                    </span>
            </a>
        </div>
        
        <!-- Desktop Options -->
        <div class="options desktop-only">
            <div class="dropdown-menu">
                <a href="/" class="dropdown-trigger">
                    Brasileiros <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Arrow Icon">
                </a>
                <div class="dropdown-content">
                    <a href="/time/flamengo">Flamengo</a>
                    <a href="/time/corinthians">Corinthians</a>
                    <a href="/time/palmeiras">Palmeiras</a>
                    <a href="/time/sao-paulo">São Paulo</a>
                    <a href="/time/santos">Santos</a>
                    <a href="/time/botafogo">Botafogo</a>
                    <a href="/time/fluminense">Fluminense</a>
                    <a href="/time/vasco">Vasco</a>
                    <a href="/time/cruzeiro">Cruzeiro</a>
                    <a href="/time/atletico-mg">Atlético-MG</a>
                    <a href="/time/gremio">Grêmio</a>
                    <a href="/time/internacional">Internacional</a>
                </div>
            </div>
            <div class="dropdown-menu">
                <a href="/" class="dropdown-trigger">
                    Internacionais <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Arrow Icon">
                </a>
                <div class="dropdown-content">
                    <a href="/time/real-madrid">Real Madrid</a>
                    <a href="/time/barcelona">Barcelona</a>
                    <a href="/time/manchester-united">Manchester United</a>
                    <a href="/time/manchester-city">Manchester City</a>
                    <a href="/time/liverpool">Liverpool</a>
                    <a href="/time/chelsea">Chelsea</a>
                    <a href="/time/arsenal">Arsenal</a>
                    <a href="/time/psg">Paris Saint-Germain</a>
                    <a href="/time/bayern-munich">Bayern München</a>
                    <a href="/time/juventus">Juventus</a>
                    <a href="/time/ac-milan">AC Milan</a>
                    <a href="/time/inter-milan">Inter Milan</a>
                </div>
            </div>
            <div class="dropdown-menu">
                <a href="/" class="dropdown-trigger">
                    Seleções <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Arrow Icon">
                </a>
                <div class="dropdown-content">
                    <a href="/selecao/brasil">Brasil</a>
                    <a href="/selecao/argentina">Argentina</a>
                    <a href="/selecao/uruguay">Uruguai</a>
                    <a href="/selecao/colombia">Colômbia</a>
                    <a href="/selecao/chile">Chile</a>
                    <a href="/selecao/espanha">Espanha</a>
                    <a href="/selecao/franca">França</a>
                    <a href="/selecao/alemanha">Alemanha</a>
                    <a href="/selecao/italia">Itália</a>
                    <a href="/selecao/portugal">Portugal</a>
                    <a href="/selecao/inglaterra">Inglaterra</a>
                    <a href="/selecao/holanda">Holanda</a>
                </div>
            </div>
        </div>
        
        <!-- Mobile & Desktop Search -->
        <div class="searchGroup">
            <div class="searchInput">
                <input type="text" id="product-search-input" placeholder="Pesquise por algum produto"
                       autocomplete="off">
                <img src="{{ asset('images/icons/search-icon.svg') }}" width="16" height="16" alt="Search Icon"
                     class="searchIcon">
            </div>
            <div id="search-results-dropdown" class="search-results-dropdown" style="display:none;"></div>
        </div>
        
        <!-- Desktop Actions -->
        <div class="header-actions desktop-only">
            <div class="userMenuContainer">
                @auth
                    <div class="userMenu">
                        <div class="userMenuTrigger">
                            <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon" class="searchIcon">
                                <span class="desktop-only">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="userMenuDropdown">
                            <a href="/minha-conta">Minha Conta</a>
                            <a href="/meus-pedidos">Meus Pedidos</a>
                            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-button">Sair</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a class="imgIcon" href="{{ route('login') }}">
                        <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon" class="searchIcon">
                            <span class="desktop-only">Entrar / Criar conta</span>
                    </a>
                @endauth
            </div>
                <a class="imgIcon cart-link" href="/carrinho">
                <img src="{{ asset('images/icons/cart-icon.png') }}" width="20" height="20" alt="Cart Icon" class="searchIcon">
                    <span class="desktop-only">
                        Carrinho
                        @php($cart = Session::get('cart'))
                        {{$cart && $cart->items->sum('quantity') > 0 ? ('('. $cart->items->sum('quantity') . ')') : ''}}
                    </span>
            </a>
        </div>
    </div>
</header>

<!-- Mobile Sidebar -->
<div class="mobile-sidebar" id="mobile-sidebar">
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <div class="sidebar-content">
        <div class="sidebar-header">
            <h3>Menu</h3>
            <button class="sidebar-close" id="sidebar-close" aria-label="Fechar Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        
        <div class="sidebar-menu">
            <!-- Brasileiros -->
            <div class="sidebar-section">
                <button class="sidebar-section-trigger" data-section="brasileiros">
                    <span>⚽ Brasileiros</span>
                    <svg class="section-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6,9 12,15 18,9"></polyline>
                    </svg>
                </button>
                <div class="sidebar-section-content" id="brasileiros-content">
                    <a href="/time/flamengo">🔴 Flamengo</a>
                    <a href="/time/corinthians">⚫ Corinthians</a>
                    <a href="/time/palmeiras">🟢 Palmeiras</a>
                    <a href="/time/sao-paulo">🔴 São Paulo</a>
                    <a href="/time/santos">⚪ Santos</a>
                    <a href="/time/botafogo">⚫ Botafogo</a>
                    <a href="/time/fluminense">🟢 Fluminense</a>
                    <a href="/time/vasco">⚫ Vasco</a>
                    <a href="/time/cruzeiro">🔵 Cruzeiro</a>
                    <a href="/time/atletico-mg">⚫ Atlético-MG</a>
                    <a href="/time/gremio">🔵 Grêmio</a>
                    <a href="/time/internacional">🔴 Internacional</a>
                </div>
            </div>
            
            <!-- Internacionais -->
            <div class="sidebar-section">
                <button class="sidebar-section-trigger" data-section="internacionais">
                    <span>🌍 Internacionais</span>
                    <svg class="section-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6,9 12,15 18,9"></polyline>
                    </svg>
                </button>
                <div class="sidebar-section-content" id="internacionais-content">
                    <a href="/time/real-madrid">👑 Real Madrid</a>
                    <a href="/time/barcelona">🔵 Barcelona</a>
                    <a href="/time/manchester-united">🔴 Manchester United</a>
                    <a href="/time/manchester-city">🔵 Manchester City</a>
                    <a href="/time/liverpool">🔴 Liverpool</a>
                    <a href="/time/chelsea">🔵 Chelsea</a>
                    <a href="/time/arsenal">🔴 Arsenal</a>
                    <a href="/time/psg">🔵 Paris Saint-Germain</a>
                    <a href="/time/bayern-munich">🔴 Bayern München</a>
                    <a href="/time/juventus">⚫ Juventus</a>
                    <a href="/time/ac-milan">🔴 AC Milan</a>
                    <a href="/time/inter-milan">🔵 Inter Milan</a>
                </div>
            </div>
            
            <!-- Seleções -->
            <div class="sidebar-section">
                <button class="sidebar-section-trigger" data-section="selecoes">
                    <span>🏆 Seleções</span>
                    <svg class="section-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6,9 12,15 18,9"></polyline>
                    </svg>
                </button>
                <div class="sidebar-section-content" id="selecoes-content">
                    <a href="/selecao/brasil">🇧🇷 Brasil</a>
                    <a href="/selecao/argentina">🇦🇷 Argentina</a>
                    <a href="/selecao/uruguay">🇺🇾 Uruguai</a>
                    <a href="/selecao/colombia">🇨🇴 Colômbia</a>
                    <a href="/selecao/chile">🇨🇱 Chile</a>
                    <a href="/selecao/espanha">🇪🇸 Espanha</a>
                    <a href="/selecao/franca">🇫🇷 França</a>
                    <a href="/selecao/alemanha">🇩🇪 Alemanha</a>
                    <a href="/selecao/italia">🇮🇹 Itália</a>
                    <a href="/selecao/portugal">🇵🇹 Portugal</a>
                    <a href="/selecao/inglaterra">🏴󠁧󠁢󠁥󠁮󠁧󠁿 Inglaterra</a>
                    <a href="/selecao/holanda">🇳🇱 Holanda</a>
                </div>
            </div>
        </div>
        
        <div class="sidebar-footer">
            <div class="sidebar-user-section">
                @auth
                    <div class="sidebar-user-info">
                        <img src="{{ asset('images/icons/user-icon.png') }}" width="32" height="32" alt="User">
                        <div class="user-details">
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <span class="user-email">{{ Auth::user()->email }}</span>
                        </div>
                    </div>
                    <div class="sidebar-user-actions">
                        <a href="/minha-conta" class="sidebar-action-btn">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            Minha Conta
                        </a>
                        <a href="/meus-pedidos" class="sidebar-action-btn">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20V6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4V4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                            </svg>
                            Meus Pedidos
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
                            @csrf
                            <button type="submit" class="sidebar-action-btn logout-btn">
                                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                </svg>
                                Sair
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="sidebar-login-btn">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/>
                        </svg>
                        Entrar / Criar conta
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

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
