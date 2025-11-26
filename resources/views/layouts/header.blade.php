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
                            <div class="userMenuHeader">
                                <div class="userInfo">
                                    <div class="userAvatar">
                                        <img src="{{ asset('images/icons/user-icon.png') }}" alt="Avatar" width="32" height="32">
                                    </div>
                                    <div class="userDetails">
                                        <span class="userName">{{ Auth::user()->name }}</span>
                                        <span class="userEmail">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="userMenuDivider"></div>
                            <div class="userMenuItems">
                                <a href="/minha-conta" class="userMenuItem">
                                    <svg class="menuIcon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                    <span>Minha Conta</span>
                                </a>
                                <a href="/meus-pedidos" class="userMenuItem">
                                    <svg class="menuIcon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20V6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4V4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                                    </svg>
                                    <span>Meus Pedidos</span>
                                </a>
                            </div>
                            <div class="userMenuDivider"></div>
                            <div class="userMenuFooter">
                                <form action="{{ route('logout') }}" method="POST" class="logoutForm">
                                    @csrf
                                    <button type="submit" class="logoutButton">
                                        <svg class="menuIcon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                        </svg>
                                        <span>Sair</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a class="imgIcon" href="{{ route('login') }}">
                        <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon" class="searchIcon">
                            <span class="desktop-only">Entrar / Criar conta</span>
                    </a>
                @endauth
            </div>
                <a class="imgIcon cart-link" href="/cart">
                <img src="{{ asset('images/icons/cart-icon.png') }}" width="20" height="20" alt="Cart Icon" class="searchIcon">
                    <span class="desktop-only">
                        Carrinho
                        @php($cart = Session::get('cart'))
                        {{$cart && $cart->items->sum('quantity') > 0 ? ('('. $cart->items->sum('quantity') . ')') : ''}}
                    </span>
            </a>
        </div>

        <div class="options desktop-only">
            <div class="dropdown-menu">
                <a href="/" class="dropdown-trigger">
                    Brasileiros <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Arrow Icon">
                </a>
                <div class="dropdown-content" id="desktop-brasileiros-content">

                </div>
            </div>
            <div class="dropdown-menu">
                <a href="/" class="dropdown-trigger">
                    Internacionais <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Arrow Icon">
                </a>
                <div class="dropdown-content" id="desktop-internacionais-content">

                </div>
            </div>
            <div class="dropdown-menu">
                <a href="/" class="dropdown-trigger">
                    Seleções <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Arrow Icon">
                </a>
                <div class="dropdown-content" id="desktop-selecoes-content">
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
                            <div class="userMenuHeader">
                                <div class="userInfo">
                                    <div class="userAvatar">
                                        <img src="{{ asset('images/icons/user-icon.png') }}" alt="Avatar" width="32" height="32">
                                    </div>
                                    <div class="userDetails">
                                        <span class="userName">{{ Auth::user()->name }}</span>
                                        <span class="userEmail">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="userMenuDivider"></div>
                            <div class="userMenuItems">
                                <a href="/minha-conta" class="userMenuItem">
                                    <svg class="menuIcon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                    <span>Minha Conta</span>
                                </a>
                                <a href="/meus-pedidos" class="userMenuItem">
                                    <svg class="menuIcon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 4V2C7 1.45 7.45 1 8 1H16C16.55 1 17 1.45 17 2V4H20V6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4V4H7ZM9 3V4H15V3H9ZM7 6V19H17V6H7Z"/>
                                    </svg>
                                    <span>Meus Pedidos</span>
                                </a>
                            </div>
                            <div class="userMenuDivider"></div>
                            <div class="userMenuFooter">
                                <form action="{{ route('logout') }}" method="POST" class="logoutForm">
                                    @csrf
                                    <button type="submit" class="logoutButton">
                                        <svg class="menuIcon" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                                        </svg>
                                        <span>Sair</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a class="imgIcon" href="{{ route('login') }}">
                        <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon" class="searchIcon">
                            <span class="desktop-only">Entrar / Criar conta</span>
                    </a>
                @endauth
            </div>
                <a class="imgIcon cart-link" href="/cart">
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
            <a href="/" class="sidebar-logo">
                <img src="{{ asset('images/logobranca.png') }}" alt="Ellon Sports Logo" width="140" height="auto">
            </a>
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

<style></style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.getElementById('product-search-input');
        const dropdown = document.getElementById('search-results-dropdown');
        let timeout = null;

        // Função para carregar times do backend
        function loadTeams() {
            fetch('/teams')
                .then(res => res.json())
                .then(teams => {
                    updateTeamsInHeader(teams);
                })
                .catch(error => {
                    console.error('Erro ao carregar times:', error);
                });
        }

        // Função para atualizar os times no header
        function updateTeamsInHeader(teams) {

            // Separar times por categoria
            const brasileiros = teams.filter(team => team.country === 'BR' && team.league !== 'Seleção');
            const internacionais = teams.filter(team => team.country !== 'BR' && team.league !== 'Seleção');
            const selecoes = teams.filter(team => team.league === 'Seleção');

            // Atualizar dropdown desktop - Brasileiros
            const brasileirosDropdown = document.getElementById('desktop-brasileiros-content');
            if (brasileirosDropdown) {
                brasileirosDropdown.innerHTML = brasileiros.map(team =>
                    `<a href="/camisas/${team.url}" class="${team.logo ? 'has-logo' : ''}">${team.logo ? `<img src="${team.logo}" alt="${team.name}" width="16" height="16" style="margin-right: 4px;">` : '⚽'} ${team.name}</a>`
                ).join('');
            }

            // Atualizar dropdown desktop - Internacionais
            const internacionaisDropdown = document.getElementById('desktop-internacionais-content');
            if (internacionaisDropdown) {
                internacionaisDropdown.innerHTML = internacionais.map(team =>
                    `<a href="/camisas/${team.url}" class="${team.logo ? 'has-logo' : ''}">${team.logo ? `<img src="${team.logo}" alt="${team.name}" width="16" height="16" style="margin-right: 4px;">` : '⚽'} ${team.name}</a>`
                ).join('');
            }

            // Atualizar dropdown desktop - Seleções
            const selecoesDropdown = document.getElementById('desktop-selecoes-content');
            if (selecoesDropdown) {
                selecoesDropdown.innerHTML = selecoes.map(team =>
                    `<a href="/camisas/${team.url}" class="${team.logo ? 'has-logo' : ''}">${team.logo ? `<img src="${team.logo}" alt="${team.name}" width="16" height="16" style="margin-right: 4px;">` : '⚽'} ${team.name}</a>`
                ).join('');
            }

            // Atualizar sidebar mobile - Brasileiros
            const brasileirosContent = document.getElementById('brasileiros-content');
            if (brasileirosContent) {
                brasileirosContent.innerHTML = brasileiros.map(team =>
                    `<a href="/camisas/${team.url}" class="sidebar-link">${team.logo ? `<img src="${team.logo}" alt="${team.name}" width="20" height="20">` : '⚽'} <span>${team.name}</span></a>`
                ).join('');
            }

            // Atualizar sidebar mobile - Internacionais
            const internacionaisContent = document.getElementById('internacionais-content');
            if (internacionaisContent) {
                internacionaisContent.innerHTML = internacionais.map(team =>
                    `<a href="/camisas/${team.url}" class="sidebar-link">${team.logo ? `<img src="${team.logo}" alt="${team.name}" width="20" height="20">` : '🌍'} <span>${team.name}</span></a>`
                ).join('');
            }

            // Atualizar sidebar mobile - Seleções
            const selecoesContent = document.getElementById('selecoes-content');
            if (selecoesContent) {
                selecoesContent.innerHTML = selecoes.map(team =>
                    `<a href="/camisas/${team.url}" class="sidebar-link">${team.logo ? `<img src="${team.logo}" alt="${team.name}" width="20" height="20">` : '🏆'} <span>${team.name}</span></a>`
                ).join('');
            }
        }

        // Carregar times ao inicializar
        loadTeams();

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
                                <img src="${product.image ?? '/images/no-image.png'}" alt="${product.name}" width="70" height="70">
                                <div>
                                    <strong>${product.name}</strong><br>
                                    <span>${product.price}</span>
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

        // Enhanced User Menu Functionality
        const userMenus = document.querySelectorAll('.userMenu');

        userMenus.forEach(userMenu => {
            const trigger = userMenu.querySelector('.userMenuTrigger');
            const dropdown = userMenu.querySelector('.userMenuDropdown');

            if (trigger && dropdown) {
                let isOpen = false;

                // Open menu function
                function openMenu() {
                    dropdown.classList.add('show');
                    isOpen = true;
                }

                // Close menu function
                function closeMenu() {
                    dropdown.classList.remove('show');
                    isOpen = false;
                }

                // Toggle menu function
                function toggleMenu() {
                    if (isOpen) {
                        closeMenu();
                    } else {
                        openMenu();
                    }
                }

                // Click handler
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleMenu();
                });

                // Close on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && isOpen) {
                        closeMenu();
                    }
                });
            }
        });

        // Close user menus when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.userMenu')) {
                userMenus.forEach(userMenu => {
                    const dropdown = userMenu.querySelector('.userMenuDropdown');
                    if (dropdown) {
                        dropdown.classList.remove('show');
                    }
                });
            }
        });
    });
</script>
