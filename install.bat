@echo off
REM 🏺 Script de Instalação - Fábrica de Vasos (Windows)
REM Execute este script para configurar o projeto automaticamente

echo 🏺 Instalando Fábrica de Vasos...
echo ==================================

REM Verificar se o Composer está instalado
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ Composer não encontrado. Instale o Composer primeiro.
    echo    Download: https://getcomposer.org/download/
    pause
    exit /b 1
)

REM Verificar se o PHP está instalado
where php >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ PHP não encontrado. Instale o PHP 8.2+ primeiro.
    pause
    exit /b 1
)

echo ✅ Pré-requisitos verificados

REM Instalar dependências
echo 📦 Instalando dependências PHP...
composer install

REM Configurar ambiente
echo ⚙️ Configurando ambiente...
if not exist .env (
    copy .env.example .env
    echo ✅ Arquivo .env criado
)

REM Gerar chave da aplicação
echo 🔑 Gerando chave da aplicação...
php artisan key:generate

REM Criar banco SQLite
echo 🗄️ Configurando banco de dados...
if not exist database\database.sqlite (
    type nul > database\database.sqlite
    echo ✅ Banco SQLite criado
)

REM Executar migrações
echo 📋 Executando migrações...
php artisan migrate

REM Executar seeders
echo 🌱 Populando banco com dados de exemplo...
php artisan db:seed

REM Criar link de storage
echo 📁 Configurando storage...
php artisan storage:link

echo.
echo 🎉 Instalação concluída com sucesso!
echo ==================================
echo.
echo 📋 Credenciais de acesso:
echo    👤 Admin: admin@fabricavasos.com / admin123
echo    👤 Cliente: cliente@teste.com / cliente123
echo.
echo 🚀 Para iniciar o servidor:
echo    php artisan serve
echo.
echo 🌐 Acesse o sistema em:
echo    http://localhost:8000
echo.
echo 📚 Documentação completa:
echo    README.md - Guia principal
echo    DEVELOPMENT.md - Guia de desenvolvimento
echo.
pause