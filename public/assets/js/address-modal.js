// Address Modal Management - Reutilizado do checkout sem afetar funcionamento original
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa máscaras se IMask estiver disponível
    if (typeof IMask !== 'undefined') {
        const zipcodeMask = IMask(document.getElementById('zip_code'), {
            mask: '00000-000'
        });
    }

    // Event listeners para botões de endereço
    document.addEventListener('click', function(e) {
        // Botão "Novo Endereço"
        if (e.target.matches('.add-address-btn, .btnPrimary[data-action="new-address"]')) {
            e.preventDefault();
            openAddressModal();
        }

        // Botão "Editar"
        if (e.target.matches('.edit-address-btn, .btnSecondary[data-action="edit-address"]')) {
            e.preventDefault();
            const addressId = e.target.getAttribute('data-address-id');
            openAddressModal(addressId);
        }

        // Botão "Excluir"
        if (e.target.matches('.delete-address-btn, .btnDanger[data-action="delete-address"]')) {
            e.preventDefault();
            const addressId = e.target.getAttribute('data-address-id');
            confirmDeleteAddress(addressId);
        }

        // Fechar modal clicando fora
        if (e.target.matches('.modal')) {
            closeAddressModal();
            closeConfirmModal();
        }
    });

    // Submissão do formulário de endereço
    const addressForm = document.getElementById('addressForm');
    if (addressForm) {
        addressForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            await saveAddress();
        });
    }

    // Busca CEP automaticamente
    const zipCodeInput = document.getElementById('zip_code');
    if (zipCodeInput) {
        zipCodeInput.addEventListener('blur', function() {
            const zipCode = this.value.replace(/\D/g, '');
            if (zipCode.length === 8) {
                searchZipCode(zipCode);
            }
        });
    }
});

// Função para abrir modal de endereço
window.openAddressModal = function(addressId = null) {
    const modal = document.getElementById('addressModal');
    const form = document.getElementById('addressForm');
    const modalTitle = document.getElementById('modalTitle');

    if (!modal || !form || !modalTitle) {
        console.error('Elementos do modal não encontrados');
        return;
    }

    // Limpa o formulário
    form.reset();
    document.getElementById('addressId').value = '';

    if (addressId) {
        modalTitle.textContent = 'Editar Endereço';
        loadAddress(addressId);
    } else {
        modalTitle.textContent = 'Novo Endereço';
        // Se for um novo endereço, verifica se é o primeiro (deve ser padrão)
        checkIfFirstAddress();
    }

    modal.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Previne scroll do body
}

// Função para fechar modal de endereço
window.closeAddressModal = function() {
    const modal = document.getElementById('addressModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Função para carregar dados do endereço para edição
async function loadAddress(addressId) {
    try {
        const response = await fetch(`/api/addresses/${addressId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
            }
        });

        if (!response.ok) {
            throw new Error('Erro ao carregar endereço');
        }

        const data = await response.json();
        const address = data.address || data;

        // Preenche o formulário
        document.getElementById('addressId').value = address.id;
        document.getElementById('zip_code').value = address.zip_code || '';
        document.getElementById('street').value = address.street || '';
        document.getElementById('number').value = address.number || '';
        document.getElementById('complement').value = address.complement || '';
        document.getElementById('neighborhood').value = address.neighborhood || '';
        document.getElementById('city').value = address.city || '';
        document.getElementById('state').value = address.state || '';
        document.getElementById('is_default').checked = address.is_default || false;

    } catch (error) {
        console.error('Erro ao carregar endereço:', error);
        showToast('Erro', 'Não foi possível carregar os dados do endereço', 'error');
    }
}

// Função para salvar endereço
async function saveAddress() {
    const form = document.getElementById('addressForm');
    const formData = new FormData(form);
    const addressId = document.getElementById('addressId').value;

    try {
        const url = addressId ? `/api/addresses/${addressId}` : '/api/addresses/';
        const method = addressId ? 'PUT' : 'POST';

        // Converte FormData para JSON
        const data = {};
        formData.forEach((value, key) => {
            if (key !== '_token') {
                data[key] = value;
            }
        });
        
        // Adiciona o campo is_default (checkbox)
        data.is_default = document.getElementById('is_default').checked;

        const response = await fetch(url, {
            method: method,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                               document.querySelector('input[name="_token"]')?.value
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok && result.success) {
            showToast('Sucesso', 'Endereço salvo com sucesso!', 'success');
            closeAddressModal();
            
            // Recarrega a página após um delay para mostrar o toast
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(result.message || 'Erro ao salvar endereço');
        }

    } catch (error) {
        console.error('Erro ao salvar endereço:', error);
        showToast('Erro', error.message || 'Não foi possível salvar o endereço', 'error');
    }
}

// Função para buscar CEP
async function searchZipCode(zipCode) {
    try {
        const response = await fetch(`https://viacep.com.br/ws/${zipCode}/json/`);
        const data = await response.json();

        if (data.erro) {
            throw new Error('CEP não encontrado');
        }

        // Preenche automaticamente os campos
        document.getElementById('street').value = data.logradouro || '';
        document.getElementById('neighborhood').value = data.bairro || '';
        document.getElementById('city').value = data.localidade || '';
        document.getElementById('state').value = data.uf || '';

        // Foca no campo número
        document.getElementById('number').focus();

    } catch (error) {
        console.error('Erro ao buscar CEP:', error);
        showToast('Atenção', 'CEP não encontrado. Preencha os dados manualmente.', 'error');
    }
}

// Função para confirmar exclusão
window.confirmDeleteAddress = function(addressId) {
    const modal = document.getElementById('confirmModal');
    const btnConfirm = document.getElementById('confirmDelete');

    if (!modal || !btnConfirm) {
        console.error('Modal de confirmação não encontrado');
        return;
    }

    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';

    // Remove listener anterior se existir
    btnConfirm.replaceWith(btnConfirm.cloneNode(true));
    const newBtnConfirm = document.getElementById('confirmDelete');

    // Adiciona novo listener
    newBtnConfirm.addEventListener('click', async function() {
        await deleteAddress(addressId);
        closeConfirmModal();
    });
}

// Função para fechar modal de confirmação
window.closeConfirmModal = function() {
    const modal = document.getElementById('confirmModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Função para deletar endereço
async function deleteAddress(addressId) {
    try {
        const response = await fetch(`/api/addresses/${addressId}`, {
            method: 'DELETE',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                               document.querySelector('input[name="_token"]')?.value
            }
        });

        const result = await response.json();

        if (response.ok && result.success) {
            showToast('Sucesso', 'Endereço excluído com sucesso!', 'success');
            
            // Recarrega a página após um delay
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(result.message || 'Erro ao excluir endereço');
        }

    } catch (error) {
        console.error('Erro ao excluir endereço:', error);
        showToast('Erro', error.message || 'Não foi possível excluir o endereço', 'error');
    }
}

// Função para mostrar toast
function showToast(title, message, type = 'success') {
    console.log('showToast called:', { title, message, type });
    
    // Se a função showToast global existir, usa ela
    if (typeof window.showToast === 'function' && window.showToast !== showToast) {
        console.log('Using global showToast');
        return window.showToast(title, message, type);
    }

    // Cria ou encontra o container
    const toastContainer = document.getElementById('toastContainer') || createToastContainer();
    console.log('Toast container:', toastContainer);
    
    // Cria o toast
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
        <div class="toast-icon">${type === 'success' ? '✓' : '⚠'}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close">&times;</button>
    `;
    
    // Adiciona evento de fechar
    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', () => {
        toast.remove();
    });
    
    // Adiciona ao container
    toastContainer.appendChild(toast);
    console.log('Toast added to container');
    
    // Força reflow e adiciona classe show
    toast.offsetHeight; // Force reflow
    setTimeout(() => {
        toast.classList.add('show');
        console.log('Toast show class added');
    }, 10);
    
    // Remove automaticamente após 5 segundos
    setTimeout(() => {
        if (toast.parentElement) {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 300); // Wait for animation
        }
    }, 5000);
}

// Torna a função global para debug
window.showToast = showToast;

// Função para verificar se é o primeiro endereço
function checkIfFirstAddress() {
    const addressCards = document.querySelectorAll('.addressCard');
    const isFirstAddress = addressCards.length === 0;
    
    if (isFirstAddress) {
        document.getElementById('is_default').checked = true;
        console.log('Primeiro endereço - marcado como padrão automaticamente');
    }
}

// Cria container de toast se não existir
function createToastContainer() {
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    return container;
}
