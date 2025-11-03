<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_completo',
        'cnpj',
        'email',
        'ddd',
        'telefone',
        'mensagem',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTelefoneCompletoAttribute(): string
    {
        return "({$this->ddd}) {$this->telefone}";
    }

    public function getCnpjFormatadoAttribute(): string
    {
        return preg_replace(
            '/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/',
            '$1.$2.$3/$4-$5',
            $this->cnpj
        );
    }
}