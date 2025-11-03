<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('cnpj', 18);
            $table->string('email');
            $table->string('ddd', 2);
            $table->string('telefone', 15);
            $table->text('mensagem');
            $table->timestamps();
            
            $table->index('email');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};