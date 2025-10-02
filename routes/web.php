<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuditController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layout');
// })->name('home');

Route::get('/', [PaginasController::class, 'index'])->name('home');
Route::get('/nosotros', [PaginasController::class, 'nosotros'])->name('nosotros');
Route::get('/propiedades', [PaginasController::class, 'propiedades'])->name('propiedades');
Route::get('/propiedad/{propiedad}', [PaginasController::class, 'propiedad'])->name('propiedad');
Route::get('/blog', [PaginasController::class, 'blog'])->name('blog');
Route::get('/entrada', [PaginasController::class, 'entrada'])->name('entrada');
Route::match(['get', 'post'], '/contacto', [PaginasController::class, 'contacto'])->name('contacto');

// Login y Autenticación
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// Administrador
Route::get('/admin', [PropertyController::class, 'index'])->name('admin');
Route::get('/admin/create', [PropertyController::class, 'create'])->name('admin.create');
Route::post('/admin/create', [PropertyController::class, 'store']);
Route::get('/admin/edit/{propiedad}', [PropertyController::class, 'edit'])->name('admin.edit');
Route::put('/admin/update/{propiedad}', [PropertyController::class, 'update'])->name('admin.update');
Route::delete('/admin/{propiedad}', [PropertyController::class, 'destroy'])->name('admin.destroy');

// Seller Authentication - Redirect to unified login
Route::get('/seller/login', function () {
    return redirect()->route('login');
})->name('seller.login');
Route::post('/seller/login', function () {
    return redirect()->route('login');
});
Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
Route::post('/seller/register', [SellerController::class, 'store']);
Route::post('/seller/logout', function () {
    return redirect()->route('logout');
})->name('seller.logout');

// Protected Seller Routes
Route::middleware('auth:seller')->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');

    // Property management for sellers
    Route::get('/seller/properties', [PropertyController::class, 'index'])->name('seller.properties.index');
    Route::get('/seller/properties/create', [PropertyController::class, 'create'])->name('seller.properties.create');
    Route::post('/seller/properties', [PropertyController::class, 'store'])->name('seller.properties.store');
    Route::get('/seller/properties/{property}/edit', [PropertyController::class, 'edit'])->name('seller.properties.edit');
    Route::put('/seller/properties/{property}', [PropertyController::class, 'update'])->name('seller.properties.update');
    Route::delete('/seller/properties/{property}', [PropertyController::class, 'destroy'])->name('seller.properties.destroy');
});

// Vendedores (Admin)
Route::get('/admin/vendedores', [AdminController::class, 'adminIndex'])->name('vendedores.index');
Route::get('/admin/vendedores/create', [SellerController::class, 'create'])->name('vendedores.create');
Route::post('/admin/vendedores/create', [SellerController::class, 'store']);
Route::get('/admin/vendedores/edit/{vendedor}', [SellerController::class, 'edit'])->name('vendedores.edit');
Route::delete('/admin/vendedores/{vendedor}', [AdminController::class, 'destroy'])->name('vendedores.destroy');

// Auditoría (Solo para usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/admin/audits', [AuditController::class, 'index'])->name('audits.index');
    Route::get('/admin/audits/stats', [AuditController::class, 'stats'])->name('audits.stats');
    Route::get('/admin/audits/{model}/{id}', [AuditController::class, 'show'])->name('audits.show');
});

// Rutas de prueba para auditoría (temporal)
Route::get('/test-audit', [App\Http\Controllers\AuditTestController::class, 'test']);
Route::get('/test-audit/create-data', [App\Http\Controllers\AuditTestController::class, 'createTestData']);
