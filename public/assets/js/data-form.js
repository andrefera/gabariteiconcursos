// Data Form Management - Máscaras e validações
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa máscaras se IMask estiver disponível
    if (typeof IMask !== 'undefined') {
        // Máscara para CPF
        const cpfMask = IMask(document.getElementById('cpf'), {
            mask: '000.000.000-00'
        });

        // Máscara para CEP
        const cepMask = IMask(document.getElementById('cep'), {
            mask: '00000-000'
        });

        // Máscara para telefone (se existir)
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            const phoneMask = IMask(phoneInput, {
                mask: '(00) 00000-0000'
            });
        }
    }

    // Busca CEP automaticamente
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            if (cep.length === 8) {
                searchZipCode(cep);
            }
        });
    }

    // Função para buscar CEP
    async function searchZipCode(cep) {
        try {
            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();
            
            if (!data.erro) {
                // Preenche os campos automaticamente
                document.getElementById('rua').value = data.logradouro || '';
                document.getElementById('bairro').value = data.bairro || '';
                document.getElementById('cidade').value = data.localidade || '';
                document.getElementById('estado').value = data.uf || '';
                
                // Foca no campo número após preencher
                document.getElementById('numero').focus();
            }
        } catch (error) {
            console.error('Erro ao buscar CEP:', error);
        }
    }

    // Validação de CPF
    function validateCPF(cpf) {
        cpf = cpf.replace(/[^\d]/g, '');
        
        if (cpf.length !== 11) return false;
        
        // Verifica se todos os dígitos são iguais
        if (/^(\d)\1{10}$/.test(cpf)) return false;
        
        // Validação do primeiro dígito verificador
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(9))) return false;
        
        // Validação do segundo dígito verificador
        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(10))) return false;
        
        return true;
    }

    // Validação em tempo real do CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('blur', function() {
            const cpf = this.value.replace(/[^\d]/g, '');
            if (cpf.length === 11) {
                if (!validateCPF(cpf)) {
                    this.setCustomValidity('CPF inválido');
                    this.classList.add('error');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('error');
                }
            }
        });
    }

    // Formatação automática do nome (primeira letra maiúscula)
    const nameInput = document.getElementById('nome');
    if (nameInput) {
        nameInput.addEventListener('blur', function() {
            this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
        });
    }
});
