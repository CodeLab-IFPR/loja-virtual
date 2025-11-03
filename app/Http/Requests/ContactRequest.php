<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContatoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome_completo' => ['required', 'string', 'max:255', 'min:3'],
            'cnpj' => ['required', 'string', 'regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$|^\d{14}$/'],
            'email' => ['required', 'email', 'max:255'],
            'ddd' => ['required', 'string', 'regex:/^\d{2}$/', 'size:2'],
            'telefone' => ['required', 'string', 'regex:/^\d{8,9}$/'],
            'mensagem' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'nome_completo.min' => 'O nome completo deve ter pelo menos 3 caracteres.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'cnpj.regex' => 'O CNPJ deve estar no formato 00.000.000/0000-00.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser válido.',
            'ddd.required' => 'O DDD é obrigatório.',
            'ddd.regex' => 'O DDD deve conter apenas 2 números.',
            'ddd.size' => 'O DDD deve ter exatamente 2 dígitos.',
            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.regex' => 'O telefone deve conter de 8 a 9 dígitos.',
            'mensagem.required' => 'A mensagem é obrigatória.',
            'mensagem.min' => 'A mensagem deve ter pelo menos 10 caracteres.',
            'mensagem.max' => 'A mensagem não pode exceder 5000 caracteres.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->cnpj) {
            $this->merge([
                'cnpj' => preg_replace('/[^0-9]/', '', $this->cnpj),
            ]);
        }

        if ($this->telefone) {
            $this->merge([
                'telefone' => preg_replace('/[^0-9]/', '', $this->telefone),
            ]);
        }
    }
}