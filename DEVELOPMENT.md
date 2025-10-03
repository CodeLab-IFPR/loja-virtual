# 🔧 Guia de Desenvolvimento - Fábrica de Vasos

## 📝 Scripts Úteis

### Comandos Artisan Frequentes
```bash
# Criar nova migração
php artisan make:migration create_table_name

# Criar novo modelo com migração
php artisan make:model ModelName -m

# Criar controller
php artisan make:controller ControllerName

# Limpar caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recriar banco do zero
php artisan migrate:fresh --seed
```

## 🗂️ Estrutura de Arquivos

### Controllers
- `CatalogController.php` - Catálogo público
- `CartController.php` - Carrinho de compras
- `Admin/DashboardController.php` - Dashboard administrativo
- `Admin/ProductController.php` - Gestão de produtos
- `Admin/CategoryController.php` - Gestão de categorias
- `Admin/UserController.php` - Gestão de usuários

### Models
- `User.php` - Usuários (admin/cliente)
- `Product.php` - Produtos
- `Category.php` - Categorias
- `Order.php` - Pedidos
- `OrderItem.php` - Itens do pedido
- `CartItem.php` - Itens do carrinho

### Middleware
- `AdminMiddleware.php` - Proteção de rotas administrativas

## 🎨 Frontend

### Tailwind CSS Classes Personalizadas
```css
/* Cores principais */
.text-primary { @apply text-green-600; }
.bg-primary { @apply bg-green-600; }
.border-primary { @apply border-green-600; }

/* Botões */
.btn-primary { @apply bg-green-600 hover:bg-green-700 text-white; }
.btn-secondary { @apply bg-gray-600 hover:bg-gray-700 text-white; }
```

### Alpine.js Components
- Gallery slider nas páginas de produto
- Modal de zoom de imagens
- Dropdown menus no header
- Formulários dinâmicos no admin

## 🔒 Autenticação e Autorização

### Tipos de Usuário
```php
// User.php
const TYPE_ADMIN = 'admin';
const TYPE_CUSTOMER = 'customer';

// Métodos úteis
$user->isAdmin()
$user->isCustomer()
$user->isApproved()
$user->canSeePrices()
```

### Middleware de Proteção
```php
// Rotas protegidas por admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Rotas administrativas
});
```

## 📸 Sistema de Upload

### Configuração de Storage
```php
// config/filesystems.php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
]
```

### Estrutura de Diretórios
```
storage/app/public/
├── categories/          # Imagens de categorias
├── products/           # Imagens de produtos
└── uploads/           # Outros uploads
```

## 🗄️ Banco de Dados

### Relacionamentos Principais
```php
// Product
belongsTo(Category::class)
hasMany(OrderItem::class)
hasMany(CartItem::class)

// User
hasMany(Order::class)
hasMany(CartItem::class)

// Order
belongsTo(User::class)
hasMany(OrderItem::class)
```

### Seeds Importantes
- `DatabaseSeeder.php` - Seeder principal
- `CategorySeeder.php` - Categorias de exemplo
- `ProductSeeder.php` - Produtos de exemplo
- `UserSeeder.php` - Usuários de teste

## 🚀 Deployment

### Checklist de Produção
- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] Configurar banco de dados de produção
- [ ] Configurar SMTP para emails
- [ ] `composer install --no-dev --optimize-autoloader`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] Configurar SSL/HTTPS
- [ ] Backup automático do banco

### Variáveis de Ambiente Importantes
```env
# Produção
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seudominio.com

# Email (exemplo com Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls

# Banco MySQL/PostgreSQL para produção
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fabrica_vasos_prod
DB_USERNAME=usuario_prod
DB_PASSWORD=senha_segura
```

## 🐛 Debug e Troubleshooting

### Logs
```bash
# Ver logs em tempo real
tail -f storage/logs/laravel.log

# Limpar logs
> storage/logs/laravel.log
```

### Problemas Comuns

#### Erro de Storage Link
```bash
php artisan storage:link
```

#### Erro de Permissões (Linux/Mac)
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### Erro de Key
```bash
php artisan key:generate
```

## 📊 Performance

### Otimizações Implementadas
- Eager loading nos relacionamentos
- Cache de configurações em produção
- Compressão de assets
- Lazy loading de imagens
- Indexação de banco otimizada

### Monitoramento
- Laravel Telescope (desenvolvimento)
- Query logging habilitado em desenvolvimento
- Error tracking em produção

## 🧪 Testes

### Estrutura de Testes
```bash
# Executar todos os testes
php artisan test

# Testes específicos
php artisan test --filter=ProductTest
```

### Cobertura de Testes
- [ ] Autenticação e autorização
- [ ] CRUD de produtos
- [ ] Sistema de carrinho
- [ ] Aprovação de clientes
- [ ] Upload de imagens

## 📈 Roadmap

### Próximas Funcionalidades
- [ ] Sistema de cupons de desconto
- [ ] Relatórios de vendas
- [ ] Integração com correios
- [ ] Sistema de avaliações
- [ ] Newsletter
- [ ] API RESTful
- [ ] Aplicativo mobile

### Melhorias Técnicas
- [ ] Testes automatizados
- [ ] CI/CD pipeline
- [ ] Docker containers
- [ ] Redis para cache
- [ ] Queue para jobs pesados