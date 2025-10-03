#!/bin/bash

# 🏺 Script de Instalação - Fábrica de Vasos
# Execute este script para configurar o projeto automaticamente

echo "🏺 Instalando Fábrica de Vasos..."
echo "=================================="

# Verificar se o Composer está instalado
if ! command -v composer &> /dev/null; then
    echo "❌ Composer não encontrado. Instale o Composer primeiro."
    echo "   Download: https://getcomposer.org/download/"
    exit 1
fi

# Verificar se o PHP está instalado
if ! command -v php &> /dev/null; then
    echo "❌ PHP não encontrado. Instale o PHP 8.2+ primeiro."
    exit 1
fi

# Verificar versão do PHP
PHP_VERSION=$(php -r "echo PHP_MAJOR_VERSION.'.'.PHP_MINOR_VERSION;")
if [ "$(printf '%s\n' "8.2" "$PHP_VERSION" | sort -V | head -n1)" != "8.2" ]; then
    echo "❌ PHP 8.2+ é necessário. Versão atual: $PHP_VERSION"
    exit 1
fi

echo "✅ Pré-requisitos verificados"

# Instalar dependências
echo "📦 Instalando dependências PHP..."
composer install

# Configurar ambiente
echo "⚙️ Configurando ambiente..."
if [ ! -f .env ]; then
    cp .env.example .env
    echo "✅ Arquivo .env criado"
fi

# Gerar chave da aplicação
echo "🔑 Gerando chave da aplicação..."
php artisan key:generate

# Criar banco SQLite
echo "🗄️ Configurando banco de dados..."
if [ ! -f database/database.sqlite ]; then
    touch database/database.sqlite
    echo "✅ Banco SQLite criado"
fi

# Executar migrações
echo "📋 Executando migrações..."
php artisan migrate

# Executar seeders
echo "🌱 Populando banco com dados de exemplo..."
php artisan db:seed

# Criar link de storage
echo "📁 Configurando storage..."
php artisan storage:link

echo ""
echo "🎉 Instalação concluída com sucesso!"
echo "=================================="
echo ""
echo "📋 Credenciais de acesso:"
echo "   👤 Admin: admin@fabricavasos.com / admin123"
echo "   👤 Cliente: cliente@teste.com / cliente123"
echo ""
echo "🚀 Para iniciar o servidor:"
echo "   php artisan serve"
echo ""
echo "🌐 Acesse o sistema em:"
echo "   http://localhost:8000"
echo ""
echo "📚 Documentação completa:"
echo "   README.md - Guia principal"
echo "   DEVELOPMENT.md - Guia de desenvolvimento"
echo ""