<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\SizeController as AdminSizeController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MaterialController as AdminMaterialController;
use App\Http\Controllers\Admin\ColorController as AdminColorController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rotas públicas
Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/catalogo', [CatalogController::class, 'catalog'])->name('catalog');
Route::get('/categoria/{category}', [CatalogController::class, 'category'])->name('catalog.category');
Route::get('/produto/{product}', [CatalogController::class, 'show'])->name('catalog.product');

// Rotas do carrinho
Route::middleware('auth')->group(function () {
    Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
    Route::post('/carrinho/adicionar', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/carrinho/{item}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/carrinho/{item}', [CartController::class, 'remove'])->name('cart.remove');
});

// Dashboard do cliente
Route::get('/dashboard', function () {
    if (Auth::user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas administrativas
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Produtos
    Route::resource('products', AdminProductController::class);
    Route::patch('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::patch('products/{product}/update-stock', [AdminProductController::class, 'updateStock'])->name('products.update-stock');
    
    // Categorias
    Route::resource('categories', AdminCategoryController::class);
    Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    
    // Tamanhos
    Route::resource('sizes', AdminSizeController::class);
    Route::patch('sizes/{size}/toggle-status', [AdminSizeController::class, 'toggleStatus'])->name('sizes.toggle-status');

    // Cores
    Route::resource('colors', AdminColorController::class);
    Route::patch('colors/{color}/toggle-status', [AdminColorController::class, 'toggleStatus'])->name('colors.toggle-status');

    // Usuários
    Route::resource('users', AdminUserController::class);
    Route::patch('users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
    Route::patch('users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
    Route::post('users/bulk-action', [AdminUserController::class, 'bulkAction'])->name('users.bulk-action');
    

    // Materiais
    Route::resource('materials', AdminMaterialController::class);
    Route::patch('materials/{material}/toggle-status', [AdminMaterialController::class, 'toggleStatus'])->name('materials.toggle-status');

    // Pedidos
    Route::resource('orders', AdminOrderController::class);
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});

// Rotas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
