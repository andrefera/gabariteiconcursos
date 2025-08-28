function openOrderModal(orderId) {
    const modal = document.getElementById('orderModal');
    const orderDetails = document.getElementById('orderDetails');
    
    modal.style.display = 'block';
    orderDetails.innerHTML = '<div class="loading">Carregando...</div>';
    
    // Fazer requisição AJAX para buscar os detalhes do pedido
    fetch('/pedido/' + orderId)
        .then(function(response) { return response.json(); })
        .then(function(data) {
            if (data.success) {
                orderDetails.innerHTML = generateOrderDetailsHTML(data.data);
            } else {
                orderDetails.innerHTML = '<div class="error">Erro ao carregar detalhes do pedido</div>';
            }
        })
        .catch(function(error) {
            console.error('Erro:', error);
            orderDetails.innerHTML = '<div class="error">Erro ao carregar detalhes do pedido</div>';
        });
}

function closeOrderModal() {
    const modal = document.getElementById('orderModal');
    modal.style.display = 'none';
}

function generateOrderDetailsHTML(order) {
    const statusClass = getStatusClass(order.status);
    var deliveredAtHtml = '';
    var discountHtml = '';
    var shippingCompanyHtml = '';
    var installmentsHtml = '';
    
    if (order.delivered_at) {
        deliveredAtHtml = '<div class="info-item"><span class="info-label">Data de Entrega</span><span class="info-value">' + order.delivered_at + '</span></div>';
    }
    
    if (order.discount) {
        discountHtml = '<div class="info-item"><span class="info-label">Desconto</span><span class="info-value">' + order.discount + '</span></div>';
    }
    
    if (order.shipping_company) {
        shippingCompanyHtml = '<div class="info-item"><span class="info-label">Transportadora</span><span class="info-value">' + order.shipping_company + '</span></div>';
    }
    
    if (order.installments) {
        installmentsHtml = '<div class="info-item"><span class="info-label">Parcelas</span><span class="info-value">' + order.installments + 'x ' + order.installment_price + '</span></div>';
    }
    
    var itemsHtml = '';
    for (var i = 0; i < order.items.length; i++) {
        var item = order.items[i];
        itemsHtml += '<div class="item-card">' +
            '<img src="' + item.product_image + '" alt="' + item.product_name + '" class="item-image">' +
            '<div class="item-details">' +
                '<div class="item-name">' + item.product_name + '</div>' +
                '<div class="item-info">Tamanho: ' + item.size + '</div>' +
                '<div class="item-info">Quantidade: ' + item.quantity + '</div>' +
                '<div class="item-info">Preço unitário: ' + item.price + '</div>' +
                '<div class="item-price">Total: ' + item.total + '</div>' +
            '</div>' +
        '</div>';
    }
    
    var paymentsHtml = '';
    if (order.payments && order.payments.length > 0) {
        paymentsHtml = '<div class="order-payments">' +
            '<h3>Informações de Pagamento</h3>';
        for (var j = 0; j < order.payments.length; j++) {
            var payment = order.payments[j];
            paymentsHtml += '<div class="payment-item">' +
                '<div class="payment-info">' +
                    '<div class="payment-method">' + payment.method + '</div>' +
                    '<div class="payment-amount">' + payment.amount + '</div>' +
                '</div>' +
            '</div>';
        }
        paymentsHtml += '</div>';
    }
    
    return '<div class="order-info">' +
        '<h3>Informações do Pedido #' + order.order_number + '</h3>' +
        '<div class="info-grid">' +
            '<div class="info-item">' +
                '<span class="info-label">Status</span>' +
                '<span class="info-value">' +
                    '<span class="status-badge ' + statusClass + '">' + order.status + '</span>' +
                '</span>' +
            '</div>' +
            '<div class="info-item">' +
                '<span class="info-label">Data do Pedido</span>' +
                '<span class="info-value">' + order.created_at + '</span>' +
            '</div>' +
            deliveredAtHtml +
            '<div class="info-item">' +
                '<span class="info-label">Valor Total</span>' +
                '<span class="info-value">' + order.final_price + '</span>' +
            '</div>' +
            discountHtml +
            '<div class="info-item">' +
                '<span class="info-label">Frete</span>' +
                '<span class="info-value">' + order.shipping_price + '</span>' +
            '</div>' +
            shippingCompanyHtml +
            installmentsHtml +
        '</div>' +
    '</div>' +
    paymentsHtml +
    '<div class="order-items">' +
        '<h3>Itens do Pedido</h3>' +
        itemsHtml +
    '</div>';
}

function getStatusClass(status) {
    const statusLower = status.toLowerCase();
    if (statusLower.indexOf('entregue') !== -1) {
        return 'status-delivered';
    } else if (statusLower.indexOf('cancelado') !== -1 || statusLower.indexOf('reembolsado') !== -1) {
        return 'status-cancelled';
    } else if (statusLower.indexOf('pago') !== -1) {
        return 'status-delivered';
    } else {
        return 'status-pending';
    }
}

// Event listeners quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar event listeners para os botões de detalhes do pedido
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('order-detail-btn')) {
            const orderId = event.target.getAttribute('data-order-id');
            openOrderModal(orderId);
        }
    });

    // Fechar modal quando clicar fora dele
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('orderModal');
        if (event.target === modal) {
            closeOrderModal();
        }
        
        const changePasswordModal = document.getElementById('changePasswordModal');
        if (event.target === changePasswordModal) {
            closeChangePasswordModal();
        }
        
        const deleteAccountModal = document.getElementById('deleteAccountModal');
        if (event.target === deleteAccountModal) {
            closeDeleteAccountModal();
        }
    });

    // Event listener para o formulário de mudança de senha
    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', handleChangePassword);
    }

    // Event listener para o formulário de exclusão de conta
    const deleteAccountForm = document.getElementById('deleteAccountForm');
    if (deleteAccountForm) {
        deleteAccountForm.addEventListener('submit', handleDeleteAccount);
    }
});

// Funções para o modal de mudança de senha
function openChangePasswordModal() {
    const modal = document.getElementById('changePasswordModal');
    modal.style.display = 'block';
    
    // Limpar formulário
    document.getElementById('changePasswordForm').reset();
}

function closeChangePasswordModal() {
    const modal = document.getElementById('changePasswordModal');
    modal.style.display = 'none';
    
    // Limpar formulário
    document.getElementById('changePasswordForm').reset();
}

function handleChangePassword(event) {
    event.preventDefault();
    
    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Mostrar loading
    submitButton.innerHTML = '<span class="loading-spinner"></span>Alterando...';
    submitButton.disabled = true;
    
    // Validar senhas
    const newPassword = document.getElementById('new_password').value;
    const confirmPassword = document.getElementById('new_password_confirmation').value;
    
    if (newPassword !== confirmPassword) {
        showToast('Erro', 'As senhas não coincidem', 'error');
        resetSubmitButton(submitButton, originalText);
        return;
    }
    
    if (newPassword.length < 6) {
        showToast('Erro', 'A nova senha deve ter pelo menos 6 caracteres', 'error');
        resetSubmitButton(submitButton, originalText);
        return;
    }
    
    // Preparar dados do formulário
    const formData = new FormData(form);
    
    // Fazer requisição AJAX
    fetch('/auth/change-password', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            showToast('Sucesso', 'Senha alterada com sucesso!', 'success');
            setTimeout(function() {
                closeChangePasswordModal();
            }, 2000);
        } else {
            if (data.errors) {
                const errorMessages = Object.values(data.errors).flat();
                showToast('Erro', errorMessages.join(', '), 'error');
            } else {
                showToast('Erro', data.message || 'Erro ao alterar senha', 'error');
            }
        }
    })
    .catch(function(error) {
        console.error('Erro:', error);
        showToast('Erro', 'Erro ao alterar senha. Tente novamente.', 'error');
    })
    .finally(function() {
        setTimeout(function() {
            resetSubmitButton(submitButton, originalText);
        }, 2000);
    });
}

// Sistema de Toast
function showToast(title, message, type) {
    const container = document.getElementById('toastContainer');
    
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;
    
    const icon = type === 'success' ? '✓' : '✕';
    
    toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div class="toast-content">
            <div class="toast-title">${title}</div>
            <div class="toast-message">${message}</div>
        </div>
        <button class="toast-close" onclick="closeToast(this)">×</button>
    `;
    
    container.appendChild(toast);
    
    // Animar entrada
    setTimeout(function() {
        toast.classList.add('show');
    }, 100);
    
    // Auto-remover após 5 segundos
    setTimeout(function() {
        closeToast(toast.querySelector('.toast-close'));
    }, 5000);
}

function closeToast(button) {
    const toast = button.closest('.toast');
    toast.classList.remove('show');
    
    setTimeout(function() {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
}

function resetSubmitButton(button, originalText) {
    button.innerHTML = originalText;
    button.disabled = false;
}

// Funções para o modal de exclusão de conta
function openDeleteAccountModal() {
    const modal = document.getElementById('deleteAccountModal');
    modal.style.display = 'block';
    
    // Limpar formulário
    document.getElementById('deleteAccountForm').reset();
}

function closeDeleteAccountModal() {
    const modal = document.getElementById('deleteAccountModal');
    modal.style.display = 'none';
    
    // Limpar formulário
    document.getElementById('deleteAccountForm').reset();
}

function handleDeleteAccount(event) {
    event.preventDefault();
    
    const form = event.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Mostrar loading
    submitButton.innerHTML = '<span class="loading-spinner"></span>Excluindo...';
    submitButton.disabled = true;
    
    // Preparar dados do formulário
    const formData = new FormData(form);
    
    // Fazer requisição AJAX
    fetch('/auth/delete-account', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(function(response) { return response.json(); })
    .then(function(data) {
        if (data.success) {
            showToast('Sucesso', 'Conta excluída com sucesso. Você será redirecionado...', 'success');
            setTimeout(function() {
                window.location.href = '/';
            }, 2000);
        } else {
            if (data.errors) {
                const errorMessages = Object.values(data.errors).flat();
                showToast('Erro', errorMessages.join(', '), 'error');
            } else {
                showToast('Erro', data.message || 'Erro ao excluir conta', 'error');
            }
        }
    })
    .catch(function(error) {
        console.error('Erro:', error);
        showToast('Erro', 'Erro ao excluir conta. Tente novamente.', 'error');
    })
    .finally(function() {
        resetSubmitButton(submitButton, originalText);
    });
}
