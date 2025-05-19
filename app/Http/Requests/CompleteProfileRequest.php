<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidCpf;
use App\Rules\ValidPhone;
use App\Rules\ValidCep;

class CompleteProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'document' => ['required', new ValidCpf],
            'phone' => ['required', new ValidPhone],
            'billing_address.street' => 'required|string|min:3',
            'billing_address.number' => 'required|string',
            'billing_address.complement' => 'nullable|string',
            'billing_address.neighborhood' => 'required|string|min:2',
            'billing_address.city' => 'required|string|min:2',
            'billing_address.state' => 'required|string|size:2',
            'billing_address.zipcode' => ['required', new ValidCep],
            'use_as_shipping' => 'boolean',
        ];
    }

    public function messages()
    {
        return [
            'document.required' => 'O CPF é obrigatório',
            'phone.required' => 'O telefone é obrigatório',
            'billing_address.street.required' => 'O nome da rua é obrigatório',
            'billing_address.street.min' => 'O nome da rua deve ter no mínimo 3 caracteres',
            'billing_address.number.required' => 'O número é obrigatório',
            'billing_address.neighborhood.required' => 'O bairro é obrigatório',
            'billing_address.neighborhood.min' => 'O nome do bairro deve ter no mínimo 2 caracteres',
            'billing_address.city.required' => 'A cidade é obrigatória',
            'billing_address.city.min' => 'O nome da cidade deve ter no mínimo 2 caracteres',
            'billing_address.state.required' => 'O estado é obrigatório',
            'billing_address.state.size' => 'O estado deve ser informado no formato UF (2 letras)',
            'billing_address.zipcode.required' => 'O CEP é obrigatório',
        ];
    }

    public function attributes()
    {
        return [
            'document' => 'CPF',
            'phone' => 'telefone',
            'billing_address.street' => 'rua',
            'billing_address.number' => 'número',
            'billing_address.complement' => 'complemento',
            'billing_address.neighborhood' => 'bairro',
            'billing_address.city' => 'cidade',
            'billing_address.state' => 'estado',
            'billing_address.zipcode' => 'CEP',
        ];
    }
} 