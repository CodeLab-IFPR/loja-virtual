<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:255'],
            'trading_name' => ['nullable', 'string', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:20'],
            'document'     => ['required', 'string', 'max:20'],
            'city'         => ['required', 'string', 'max:100'],
            'cep'          => ['required', 'string', 'max:9'],
            'street'       => ['required', 'string', 'max:255'],
            'number'       => ['required', 'string', 'max:20'],
            'complement'   => ['nullable', 'string', 'max:255'],
            'state'        => ['required', 'string', 'size:2'],
        ];
    }

    public function messages(): array
    {
        return [
            'contact_name.required' => 'O nome do responsável é obrigatório.',
            'city.required'         => 'A cidade é obrigatória.',
            'cep.max'               => 'CEP inválido.',
            'state.size'            => 'O estado deve ter 2 letras (ex: SP).',
        ];
    }
}