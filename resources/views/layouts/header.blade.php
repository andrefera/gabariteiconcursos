<header id="header">
    <div class="alignHeader">
        <a href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Ellon Sports Logo">
        </a>
        <div class="options">
            <a href="/">Brasileiros <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Search Icon"></a>
            <a href="/">Internacionais <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Search Icon"> </a>
            <a href="/">Seleções <img src="{{ asset('images/icons/arrow-down-icon.png') }}" width="10" height="10" alt="Search Icon"> </a>
        </div>
        <div class="searchGroup">
            <div class="searchInput">
                <input type="text" placeholder="Pesquise por algum produto">
                <img src="{{ asset('images/icons/search-icon.svg') }}" width="16" height="16" alt="Search Icon"
                     class="searchIcon">
            </div>
        </div>
        <div class="userMenuContainer">
            @auth
                <div class="userMenu">
                    <div class="userMenuTrigger">
                        <img src="{{ asset('images/icons/user-icon.png') }}" width="18" height="18" alt="User Icon" class="searchIcon">
                        <span>{{ Auth::user()->name }}</span>
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
                    Entrar / Criar conta
                </a>
            @endauth
        </div>
        <a class="imgIcon" href="/carrinho">
            <img src="{{ asset('images/icons/cart-icon.png') }}" width="20" height="20" alt="Cart Icon" class="searchIcon">
            <p>Carrinho</p>
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
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userMenu = document.querySelector('.userMenu');
    if (userMenu) {
        userMenu.addEventListener('click', function(e) {
            const dropdown = this.querySelector('.userMenuDropdown');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            } else {
                dropdown.style.display = 'block';
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target)) {
                const dropdown = userMenu.querySelector('.userMenuDropdown');
                dropdown.style.display = 'none';
            }
        });
    }
});
</script>
