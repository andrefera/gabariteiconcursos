@extends('layouts.app')
@section('title', 'Ellon Sports | Complete seu cadastro')

<!-- Add Toastify CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

@section('content')
<div class="container">
    <div class="profile-complete-container">
        <h1>Complete seu cadastro</h1>
        <p>Para prosseguir com a compra, precisamos de algumas informações adicionais.</p>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="profileForm" class="profile-form">
            @csrf
            <div class="form-group">
                <label for="document">CPF</label>
                <input type="text"
                       id="document"
                       name="document"
                       class="form-control @error('document') is-invalid @enderror"
                       value="{{ old('document', $user->document) }}"
                       required>
                @error('document')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Telefone</label>
                <input type="text"
                       id="phone"
                       name="phone"
                       class="form-control @error('phone') is-invalid @enderror"
                       value="{{ old('phone', $user->phone) }}"
                       required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="billing_address">Endereço de Cobrança</label>
                <input type="text"
                       id="street"
                       name="billing_address[street]"
                       class="form-control @error('billing_address.street') is-invalid @enderror"
                       placeholder="Rua"
                       value="{{ old('billing_address.street', $address['street']) }}"
                       required>
                @error('billing_address.street')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <input type="text"
                       id="number"
                       name="billing_address[number]"
                       class="form-control @error('billing_address.number') is-invalid @enderror"
                       placeholder="Número"
                       value="{{ old('billing_address.number', $address['number']) }}"
                       required>
                @error('billing_address.number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <input type="text"
                       id="complement"
                       name="billing_address[complement]"
                       class="form-control @error('billing_address.complement') is-invalid @enderror"
                       placeholder="Complemento"
                       value="{{ old('billing_address.complement', $address['complement']) }}">
                @error('billing_address.complement')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <input type="text"
                       id="neighborhood"
                       name="billing_address[neighborhood]"
                       class="form-control @error('billing_address.neighborhood') is-invalid @enderror"
                       placeholder="Bairro"
                       value="{{ old('billing_address.neighborhood', $address['neighborhood']) }}"
                       required>
                @error('billing_address.neighborhood')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <input type="text"
                       id="city"
                       name="billing_address[city]"
                       class="form-control @error('billing_address.city') is-invalid @enderror"
                       placeholder="Cidade"
                       value="{{ old('billing_address.city', $address['city']) }}"
                       required>
                @error('billing_address.city')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <select id="state"
                        name="billing_address[state]"
                        class="form-control @error('billing_address.state') is-invalid @enderror"
                        required>
                    <option value="">Selecione o estado</option>
                    <option value="AC" {{ old('billing_address.state', $address['state']) == 'AC' ? 'selected' : '' }}>Acre</option>
                    <option value="AL" {{ old('billing_address.state', $address['state']) == 'AL' ? 'selected' : '' }}>Alagoas</option>
                    <option value="AP" {{ old('billing_address.state', $address['state']) == 'AP' ? 'selected' : '' }}>Amapá</option>
                    <option value="AM" {{ old('billing_address.state', $address['state']) == 'AM' ? 'selected' : '' }}>Amazonas</option>
                    <option value="BA" {{ old('billing_address.state', $address['state']) == 'BA' ? 'selected' : '' }}>Bahia</option>
                    <option value="CE" {{ old('billing_address.state', $address['state']) == 'CE' ? 'selected' : '' }}>Ceará</option>
                    <option value="DF" {{ old('billing_address.state', $address['state']) == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                    <option value="ES" {{ old('billing_address.state', $address['state']) == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                    <option value="GO" {{ old('billing_address.state', $address['state']) == 'GO' ? 'selected' : '' }}>Goiás</option>
                    <option value="MA" {{ old('billing_address.state', $address['state']) == 'MA' ? 'selected' : '' }}>Maranhão</option>
                    <option value="MT" {{ old('billing_address.state', $address['state']) == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                    <option value="MS" {{ old('billing_address.state', $address['state']) == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                    <option value="MG" {{ old('billing_address.state', $address['state']) == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                    <option value="PA" {{ old('billing_address.state', $address['state']) == 'PA' ? 'selected' : '' }}>Pará</option>
                    <option value="PB" {{ old('billing_address.state', $address['state']) == 'PB' ? 'selected' : '' }}>Paraíba</option>
                    <option value="PR" {{ old('billing_address.state', $address['state']) == 'PR' ? 'selected' : '' }}>Paraná</option>
                    <option value="PE" {{ old('billing_address.state', $address['state']) == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                    <option value="PI" {{ old('billing_address.state', $address['state']) == 'PI' ? 'selected' : '' }}>Piauí</option>
                    <option value="RJ" {{ old('billing_address.state', $address['state']) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                    <option value="RN" {{ old('billing_address.state', $address['state']) == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                    <option value="RS" {{ old('billing_address.state', $address['state']) == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                    <option value="RO" {{ old('billing_address.state', $address['state']) == 'RO' ? 'selected' : '' }}>Rondônia</option>
                    <option value="RR" {{ old('billing_address.state', $address['state']) == 'RR' ? 'selected' : '' }}>Roraima</option>
                    <option value="SC" {{ old('billing_address.state', $address['state']) == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                    <option value="SP" {{ old('billing_address.state', $address['state']) == 'SP' ? 'selected' : '' }}>São Paulo</option>
                    <option value="SE" {{ old('billing_address.state', $address['state']) == 'SE' ? 'selected' : '' }}>Sergipe</option>
                    <option value="TO" {{ old('billing_address.state', $address['state']) == 'TO' ? 'selected' : '' }}>Tocantins</option>
                </select>
                @error('billing_address.state')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <input type="text"
                       id="zipcode"
                       name="billing_address[zipcode]"
                       class="form-control @error('billing_address.zipcode') is-invalid @enderror"
                       placeholder="CEP"
                       value="{{ old('billing_address.zipcode', $address['zipcode']) }}"
                       required>
                @error('billing_address.zipcode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="use_as_shipping" value="1">
                    Usar como endereço de entrega
                </label>
            </div>

            <button type="submit" class="btn-continue">Salvar e Continuar</button>
        </form>
    </div>
</div>

<style>
.profile-complete-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
}

.profile-form {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.invalid-feedback {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: -8px;
    margin-bottom: 10px;
}

.alert {
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.btn-continue {
    width: 100%;
    padding: 10px;
    background: #FF7F00;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
}

.btn-continue:hover {
    background: #e67300;
}
</style>

<script src="https://unpkg.com/imask"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    // Function to show toast message
    function showToast(message, isError = false) {
        Toastify({
            text: message,
            duration: 3000,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
                background: isError ? "#dc3545" : "#28a745",
                borderRadius: "4px",
                fontSize: "14px",
                padding: "12px 24px"
            }
        }).showToast();
    }

    // Function to handle form errors
    function handleFormErrors(errors) {
        // Clear previous error states
        document.querySelectorAll('.is-invalid').forEach(field => {
            field.classList.remove('is-invalid');
        });

        // Show error messages and mark fields as invalid
        if (typeof errors === 'object') {
            Object.keys(errors).forEach(key => {
                const field = document.querySelector(`[name="${key}"]`) ||
                            document.querySelector(`[name="${key.replace('.', '][')}]`);
                if (field) {
                    field.classList.add('is-invalid');
                }
                if (Array.isArray(errors[key])) {
                    errors[key].forEach(error => showToast(error, true));
                } else {
                    showToast(errors[key], true);
                }
            });
        } else if (Array.isArray(errors)) {
            errors.forEach(error => showToast(error, true));
        } else {
            showToast(errors, true);
        }
    }

    // Mask for CPF
    const documentMask = IMask(document.getElementById('document'), {
        mask: '000.000.000-00'
    });

    // Mask for phone
    const phoneMask = IMask(document.getElementById('phone'), {
        mask: [
            {
                mask: '(00) 0000-0000'
            },
            {
                mask: '(00) 00000-0000'
            }
        ]
    });

    // Mask for zipcode
    const zipcodeMask = IMask(document.getElementById('zipcode'), {
        mask: '00000-000'
    });

    // Validate CPF
    function validateCPF(cpf) {
        cpf = cpf.replace(/[^\d]/g, '');

        if (cpf.length !== 11) return false;
        if (/^(\d)\1+$/.test(cpf)) return false;

        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let rev = 11 - (sum % 11);
        if (rev === 10 || rev === 11) rev = 0;
        if (rev !== parseInt(cpf.charAt(9))) return false;

        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        rev = 11 - (sum % 11);
        if (rev === 10 || rev === 11) rev = 0;
        if (rev !== parseInt(cpf.charAt(10))) return false;

        return true;
    }

    // Validate phone
    function validatePhone(phone) {
        phone = phone.replace(/[^\d]/g, '');
        if (phone.length !== 10 && phone.length !== 11) return false;
        if (phone.length === 11 && phone[2] !== '9') return false;
        const ddd = parseInt(phone.substring(0, 2));
        if (ddd < 11 || ddd > 99) return false;
        return true;
    }

    // Auto-fill address from CEP
    const addressFields = {
        street: document.getElementById('street'),
        neighborhood: document.getElementById('neighborhood'),
        city: document.getElementById('city'),
        state: document.getElementById('state')
    };

    function setAddressFieldsDisabled(disabled) {
        Object.values(addressFields).forEach(field => {
            if (field.id === 'state') {
                field.disabled = disabled;
                field.style.backgroundColor = disabled ? '#f8f9fa' : '';
            } else {
                field.disabled = disabled;
                field.style.backgroundColor = disabled ? '#f8f9fa' : '';
            }
        });
    }

    function clearAddressFields() {
        Object.values(addressFields).forEach(field => {
            if (field.id === 'state') {
                field.value = '';
            } else if (field.id !== 'zipcode') {
                field.value = '';
            }
        });
    }

    // Form submission
    document.getElementById('profileForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Client-side validation
        const cpf = document.getElementById('document').value;
        const phone = document.getElementById('phone').value;
        const errors = [];

        if (!validateCPF(cpf)) {
            errors.push('CPF inválido');
            document.getElementById('document').classList.add('is-invalid');
        }

        if (!validatePhone(phone)) {
            errors.push('Telefone inválido');
            document.getElementById('phone').classList.add('is-invalid');
        }

        if (errors.length > 0) {
            errors.forEach(error => showToast(error, true));
            return;
        }

        try {
            // Temporarily enable all fields to include them in the FormData
            const disabledFields = Array.from(this.querySelectorAll('input:disabled, select:disabled'));
            disabledFields.forEach(field => field.disabled = false);

            const formData = new FormData(this);
            const formDataObj = {};

            // Convert FormData to object with nested structure
            formData.forEach((value, key) => {
                // Handle billing_address[field] format
                if (key.includes('[') && key.includes(']')) {
                    const matches = key.match(/^([^\[]+)\[([^\]]+)\]$/);
                    if (matches) {
                        const [, parent, child] = matches;
                        formDataObj[parent] = formDataObj[parent] || {};
                        formDataObj[parent][child] = value;
                    }
                } else {
                    formDataObj[key] = value;
                }
            });

            // Re-disable the fields that were disabled
            disabledFields.forEach(field => field.disabled = true);

            const response = await fetch('{{ route('profile.complete.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formDataObj)
            });

            const data = await response.json();
            console.log(data);

            if (!response.ok) {
                if (data.errors) {
                    handleFormErrors(data.errors);
                } else {
                    showToast('Ocorreu um erro ao salvar os dados. Tente novamente.', true);
                }
                return;
            }

            showToast('Perfil atualizado com sucesso!');

            // Redirect if needed
            if (data.redirect) {
                window.location.href = data.redirect;
            }

        } catch (error) {
            console.error('Erro ao enviar formulário:', error);
            showToast('Erro ao enviar formulário. Tente novamente mais tarde.', true);
        }
    });

    let zipcodeField = document.getElementById('zipcode');
    zipcodeField.addEventListener('blur', async function() {
        const cep = this.value.replace(/\D/g, '');

        if (cep.length !== 8) {
            this.classList.add('is-invalid');
            clearAddressFields();
            setAddressFieldsDisabled(false);
            showToast('CEP inválido', true);
            return;
        }

        try {
            setAddressFieldsDisabled(true);
            zipcodeField.style.backgroundColor = '#f8f9fa';

            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
            const data = await response.json();

            if (data.erro) {
                this.classList.add('is-invalid');
                showToast('CEP não encontrado', true);
                clearAddressFields();
                setAddressFieldsDisabled(false);
                return;
            }

            // Preenche os campos
            addressFields.street.value = data.logradouro || '';
            addressFields.neighborhood.value = data.bairro || '';
            addressFields.city.value = data.localidade || '';

            // Set state in select element
            if (data.uf) {
                addressFields.state.value = data.uf.toUpperCase();
            }

            // Configura os campos como somente leitura em vez de disabled
            Object.values(addressFields).forEach(field => {
                const hasValue = field.value.trim() !== '';
                if (hasValue) {
                    field.readOnly = true;
                    field.style.backgroundColor = '#f8f9fa';
                } else {
                    field.readOnly = false;
                    field.style.backgroundColor = '';
                }
                // Importante: não desabilita mais os campos
                field.disabled = false;
            });

            this.classList.remove('is-invalid');

            // Foca no campo número se o logradouro foi preenchido
            if (data.logradouro) {
                document.getElementById('number').focus();
            }
            // Senão, foca no primeiro campo vazio
            else {
                const firstEmptyField = [
                    addressFields.street,
                    addressFields.neighborhood,
                    addressFields.city,
                    addressFields.state
                ].find(field => !field.value);

                if (firstEmptyField) {
                    firstEmptyField.focus();
                }
            }

        } catch (error) {
            console.error('Erro ao buscar CEP:', error);
            showToast('Erro ao buscar CEP. Tente novamente mais tarde.', true);
            clearAddressFields();
            setAddressFieldsDisabled(false);
        }
    });

    // Remove invalid class on input
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endsection
