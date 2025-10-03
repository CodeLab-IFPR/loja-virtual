# 🛒 Loja Virtual - Sistema E-commerce B2B

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.31.0-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2.12-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Alpine.js-3.14.1-8BC34A?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white" alt="SQLite">
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Desenvolvido_por-CodeLab_IFPR-0066CC?style=for-the-badge&logo=graduation-cap&logoColor=white" alt="CodeLab IFPR">
  <img src="https://img.shields.io/badge/IFPR-Campus_Paranavaí-228B22?style=for-the-badge&logo=school&logoColor=white" alt="IFPR Paranavaí">
  <img src="https://img.shields.io/badge/Projeto_de-Extensão-FF6600?style=for-the-badge&logo=handshake&logoColor=white" alt="Projeto de Extensão">
</p>

<p align="center">
  <strong>🎯 Sistema completo de e-commerce B2B desenvolvido pelo CodeLab IFPR</strong><br>
  <em>Solução profissional para empresas que precisam de catálogo online, gestão de clientes e vendas B2B</em>
</p>

## 📋 Sobre o Projeto

Sistema completo de loja virtual B2B desenvolvido em Laravel com interface moderna e funcionalidades específicas para comércio eletrônico empresarial. O sistema oferece um catálogo público com controle de acesso para visualização de preços e um painel administrativo completo para gestão de produtos, categorias, clientes e pedidos.

### ✨ Principais Funcionalidades

- **🛍️ Catálogo Público**: Navegação por categorias e produtos com galeria de imagens
- **🔐 Sistema de Autenticação**: Registro de clientes com aprovação administrativa
- **💰 Controle de Preços**: Visualização condicionada à aprovação do cliente
- **🛒 Sistema de Carrinho**: Adicionar produtos e gerenciar quantidades
- **👤 Perfil de Cliente**: Gerenciamento de dados pessoais e histórico
- **⚙️ Painel Administrativo**: Gestão completa de produtos, categorias, clientes e pedidos
- **📸 Galeria de Imagens**: Upload múltiplo com modal de zoom
- **📱 Design Responsivo**: Interface adaptável para todos os dispositivos

### 🎯 Diferenciais

- **Sistema B2B**: Foco em vendas para empresas, lojistas e revendedores
- **Aprovação Manual**: Controle total sobre quem pode visualizar preços
- **Gestão de Estoque**: Controle automático de disponibilidade de produtos
- **Interface Moderna**: Design profissional e responsivo com Tailwind CSS
- **Experiência Otimizada**: Carregamento rápido e navegação intuitiva
- **Multi-segmento**: Adaptável para qualquer tipo de produto ou serviço

## 🚀 Tecnologias Utilizadas

### Backend
- **[Laravel 11.31.0](https://laravel.com)** - Framework PHP moderno
- **[PHP 8.2.12](https://php.net)** - Linguagem de programação
- **[Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)** - Kit de autenticação
- **[SQLite](https://sqlite.org)** - Banco de dados relacional
- **[Eloquent ORM](https://laravel.com/docs/eloquent)** - Mapeamento objeto-relacional

### Frontend
- **[Tailwind CSS 3.4.0](https://tailwindcss.com)** - Framework CSS utilitário
- **[Alpine.js 3.14.1](https://alpinejs.dev)** - Framework JavaScript reativo
- **[Blade Templates](https://laravel.com/docs/blade)** - Engine de templates do Laravel
- **[Vite](https://vitejs.dev)** - Bundler de assets (via CDN)

### Ferramentas e Bibliotecas
- **[Composer](https://getcomposer.org)** - Gerenciador de dependências PHP
- **[Artisan](https://laravel.com/docs/artisan)** - Interface de linha de comando do Laravel
- **[Laravel Mix](https://laravel-mix.com)** - Compilação de assets
- **[Storage](https://laravel.com/docs/filesystem)** - Sistema de arquivos para uploads

## � Instalação Rápida

### Script Automático (Recomendado)

Para instalação rápida, use os scripts inclusos:

**Linux/Mac:**
```bash
chmod +x install.sh
./install.sh
```

**Windows:**
```batch
install.bat
```

### Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- **PHP >= 8.2** com extensões: OpenSSL, PDO, Mbstring, Tokenizer, XML, Ctype, JSON, BCMath, Fileinfo
- **Composer >= 2.0**
- **Git**
- **Servidor Web** (Apache, Nginx ou servidor embutido do PHP)

#### 1. Clone o Repositório
```bash
git clone https://github.com/seu-usuario/loja-virtual.git
cd loja-virtual
```

#### 2. Instale as Dependências PHP
```bash
composer install
```

#### 3. Configure o Ambiente
```bash
# Copie o arquivo de configuração
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

#### 4. Configure o Banco de Dados
Edite o arquivo `.env` com suas configurações:

```env
# Banco de dados SQLite (padrão)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Ou use MySQL/PostgreSQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=loja_virtual
# DB_USERNAME=seu_usuario
# DB_PASSWORD=sua_senha
```

#### 5. Crie o Banco de Dados SQLite
```bash
# Para SQLite, crie o arquivo do banco
touch database/database.sqlite
```

#### 6. Execute as Migrações e Seeders
```bash
# Execute as migrações
php artisan migrate

# Execute os seeders (dados de exemplo)
php artisan db:seed
```

#### 7. Configure o Storage
```bash
# Criar link simbólico para uploads
php artisan storage:link
```

#### 8. Inicie o Servidor
```bash
# Servidor de desenvolvimento
php artisan serve
```

O sistema estará disponível em: `http://localhost:8000`

## ⚙️ Comandos Úteis

### Desenvolvimento
```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recriar banco de dados
php artisan migrate:fresh --seed

# Gerar novos dados de teste
php artisan db:seed

# Atualizar link de storage
php artisan storage:link

# Listar rotas
php artisan route:list

# Modo manutenção
php artisan down
php artisan up
```

### Banco de Dados
```bash
# Criar migration
php artisan make:migration create_table_name

# Criar seeder
php artisan make:seeder TableNameSeeder

# Criar model com migration
php artisan make:model ModelName -m

# Rollback migration
php artisan migrate:rollback
```

### 🔑 Credenciais Padrão

#### Administrador
- **Email**: admin@lojavirtual.com
- **Senha**: admin123

#### Cliente de Teste
- **Email**: cliente@teste.com
- **Senha**: cliente123

## 📁 Estrutura do Projeto

```
loja-virtual/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/           # Controllers do painel administrativo
│   │   ├── CatalogController.php
│   │   └── CartController.php
│   ├── Models/
│   │   ├── User.php         # Usuários (admin/cliente)
│   │   ├── Category.php     # Categorias de produtos
│   │   ├── Product.php      # Produtos
│   │   ├── Order.php        # Pedidos
│   │   └── CartItem.php     # Itens do carrinho
│   └── Middleware/
│       └── AdminMiddleware.php
├── database/
│   ├── migrations/          # Estrutura do banco
│   └── seeders/            # Dados de exemplo
├── resources/
│   └── views/
│       ├── layouts/        # Layouts base
│       ├── catalog/        # Views públicas
│       ├── admin/          # Painel administrativo
│       └── auth/           # Autenticação
├── public/
│   └── storage/           # Arquivos públicos (imagens)
└── storage/
    └── app/public/        # Upload de arquivos
```

## 🎨 Principais Recursos

### Catálogo Público
- ✅ Navegação por categorias
- ✅ Busca de produtos
- ✅ Galeria de imagens com zoom
- ✅ Especificações técnicas
- ✅ Sistema de carrinho

### Painel Administrativo
- ✅ Dashboard com estatísticas
- ✅ CRUD completo de produtos
- ✅ Gestão de categorias
- ✅ Aprovação de clientes
- ✅ Controle de estoque
- ✅ Upload múltiplo de imagens

### Sistema de Usuários
- ✅ Registro de clientes
- ✅ Aprovação manual por admin
- ✅ Controle de acesso por roles
- ✅ Perfil personalizável

## 🛡️ Segurança

- **Autenticação**: Laravel Breeze com proteção CSRF
- **Autorização**: Middleware customizado para admin
- **Validação**: Validação server-side em todos os formulários
- **Upload Seguro**: Validação de tipos e tamanhos de arquivo
- **SQL Injection**: Proteção via Eloquent ORM

## 📱 Responsividade

O sistema é totalmente responsivo e funciona perfeitamente em:
- 📱 **Mobile**: Smartphones (320px+)
- 📱 **Tablet**: Tablets (768px+)
- 💻 **Desktop**: Computadores (1024px+)
- 🖥️ **Large**: Telas grandes (1280px+)

## � Troubleshooting

### Problemas Comuns

#### 1. Erro de permissão no storage
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

#### 2. Imagens não aparecem
```bash
php artisan storage:link
```

#### 3. Erro de APP_KEY
```bash
php artisan key:generate
```

#### 4. Erro de dependências do Composer
```bash
composer install --no-dev
composer dump-autoload
```

#### 5. Banco SQLite não existe
```bash
touch database/database.sqlite
php artisan migrate
```

### Logs de Erro
```bash
# Visualizar logs em tempo real
tail -f storage/logs/laravel.log

# Limpar logs antigos
echo "" > storage/logs/laravel.log
```

## �🚀 Deployment

### Produção
```bash
# Otimizações para produção
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Configure as variáveis de ambiente
APP_ENV=production
APP_DEBUG=false
```

## 🤝 Contribuição

Este projeto é mantido pelo **CodeLab IFPR** e aceita contribuições da comunidade!

### Como Contribuir:

1. **Fork** o projeto
2. **Crie** uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. **Commit** suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. **Push** para a branch (`git push origin feature/AmazingFeature`)
5. **Abra** um Pull Request

### Diretrizes:

- 📋 Siga os padrões de código estabelecidos
- 🧪 Adicione testes quando necessário
- 📝 Documente novas funcionalidades
- 💬 Descreva claramente suas mudanças

### 🎓 Oportunidades para Estudantes

O CodeLab IFPR oferece oportunidades para estudantes participarem do desenvolvimento:
- 🚀 **Projetos de Extensão**: Participe de projetos reais
- 💡 **Estágios**: Oportunidades de estágio em desenvolvimento
- 🏆 **Portfólio**: Construa um portfólio sólido
- 🤝 **Networking**: Conecte-se com a comunidade tech

## 📄 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 👨‍💻 Desenvolvido por

<p align="center">
  <a href="https://codelabifpr.com.br/" target="_blank">
    <img src="https://img.shields.io/badge/Desenvolvido_pelo-CodeLab_IFPR-0066CC?style=for-the-badge&logo=data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJMMTMuMDkgOC4yNkwyMCA5TDEzLjA5IDE1Ljc0TDEyIDIyTDEwLjkxIDE1Ljc0TDQgOUwxMC45MSA4LjI2TDEyIDJaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K&logoColor=white" alt="CodeLab IFPR">
  </a>
</p>

### 🏫 Sobre o CodeLab IFPR

O **[CodeLab IFPR](https://codelabifpr.com.br/)** é um projeto de extensão do IFPR Campus Paranavaí que oferece soluções tecnológicas inovadoras para a comunidade e promove a formação prática dos estudantes através de projetos reais.

**Missão**: Conectar conhecimento acadêmico com demandas do mercado, desenvolvendo soluções que impactam positivamente a sociedade.

**Valores**:
- 🎓 **Educação Prática**: Aprendizado através de projetos reais
- 🌟 **Inovação**: Soluções criativas e modernas
- 🤝 **Comunidade**: Compromisso com o desenvolvimento regional
- 💡 **Excelência**: Qualidade em cada entrega

**Serviços**:
- 💻 Desenvolvimento de sistemas web e mobile
- 🏪 Soluções e-commerce personalizadas
- 📊 Sistemas de gestão empresarial
- 🎯 Consultoria em tecnologia da informação
- 📱 Aplicações mobile nativas e híbridas

---

**Contato CodeLab IFPR**:
- 🌐 **Website**: [codelabifpr.com.br](https://codelabifpr.com.br/)
- 📧 **Email**: contato@codelabifpr.com.br
- 📍 **Local**: IFPR Campus Paranavaí - PR

## 📞 Suporte

Para suporte técnico e dúvidas sobre o projeto:

**🏢 CodeLab IFPR**
- 🌐 **Website**: [codelabifpr.com.br](https://codelabifpr.com.br/)
- 📧 **Email**: contato@codelabifpr.com.br
- 💬 **Issues**: [GitHub Issues](https://github.com/seu-usuario/loja-virtual/issues)

**📚 Documentação e Recursos**
- 📖 **Documentação**: Consulte este README.md
- 🎥 **Tutoriais**: Disponíveis no site do CodeLab
- 🛠️ **Customização**: Entre em contato para adaptações específicas

---

<p align="center">
  Desenvolvido com ❤️ pelo <a href="https://codelabifpr.com.br/" target="_blank"><strong>CodeLab IFPR</strong></a><br>
  <small>Projeto de Extensão - IFPR Campus Paranavaí</small>
</p>
