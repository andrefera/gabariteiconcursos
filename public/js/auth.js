class Auth {
    constructor() {
        this.token = localStorage.getItem('jwt_token');
        this.user = null;
        this.initialized = false;
    }

    async initialize() {
        if (this.initialized) return;
        
        if (this.token) {
            try {
                await this.fetchUser();
            } catch (error) {
                console.error('Error initializing auth:', error);
                this.logout();
            }
        }
        
        this.initialized = true;
    }

    async fetchUser() {
        try {
            const response = await fetch('/auth/me', {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            });

            const data = await response.json();
            
            if (data.success) {
                this.user = data.user;
                this.updateUI();
            } else {
                throw new Error('Failed to fetch user');
            }
        } catch (error) {
            console.error('Error fetching user:', error);
            this.logout();
        }
    }

    updateUI() {
        const userMenuContainer = document.querySelector('.userMenuContainer');
        if (!userMenuContainer) return;

        if (this.user) {
            userMenuContainer.innerHTML = `
                <div class="userMenu">
                    <a class="imgIcon userMenuTrigger" href="javascript:void(0)">
                        <img src="/images/icons/user-icon.png" width="18" height="18" alt="User Icon" class="searchIcon">
                        ${this.user.name}
                        <img src="/images/icons/arrow-down-icon.png" width="10" height="10" alt="Arrow Icon">
                    </a>
                    <div class="userMenuDropdown">
                        <a href="/minha-conta">Minha Conta</a>
                        <a href="/meus-pedidos">Meus Pedidos</a>
                        <a href="#" onclick="auth.logout(); return false;">Sair</a>
                    </div>
                </div>
            `;
        } else {
            userMenuContainer.innerHTML = `
                <a class="imgIcon" href="/login">
                    <img src="/images/icons/user-icon.png" width="18" height="18" alt="User Icon" class="searchIcon">
                    Entrar / Criar conta
                </a>
            `;
        }
    }

    logout() {
        localStorage.removeItem('jwt_token');
        this.token = null;
        this.user = null;
        this.updateUI();
        window.location.href = '/';
    }

    getToken() {
        return this.token;
    }

    isAuthenticated() {
        return !!this.token && !!this.user;
    }
}

// Initialize auth globally
const auth = new Auth();

// Add JWT token to all fetch requests
const originalFetch = window.fetch;
window.fetch = async function(...args) {
    const [resource, config] = args;
    
    // Clone the config to avoid modifying the original
    const newConfig = { ...config } || {};
    newConfig.headers = { ...newConfig.headers } || {};
    
    const token = auth.getToken();
    if (token) {
        newConfig.headers['Authorization'] = `Bearer ${token}`;
    }
    
    return originalFetch(resource, newConfig);
};

// Initialize auth when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    auth.initialize();
}); 