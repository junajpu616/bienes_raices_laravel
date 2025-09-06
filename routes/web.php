<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PaginasController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SellerController;
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

// Administrador
Route::get('/admin', [PropertyController::class, 'index'])->name('admin');
Route::get('/admin/create', [PropertyController::class, 'create'])->name('admin.create');
Route::post('/admin/create', [PropertyController::class, 'store']);
Route::get('/admin/edit/{propiedad}', [PropertyController::class, 'edit'])->name('admin.edit');
Route::put('/admin/update/{propiedad}', [PropertyController::class, 'update'])->name('admin.update');
Route::delete('/admin/{propiedad}', [PropertyController::class, 'destroy'])->name('admin.destroy');

// Vendedores
Route::get('/admin/vendedores/create', [SellerController::class, 'create'])->name('vendedores.create');
Route::post('/admin/vendedores/create', [SellerController::class, 'store']);
Route::get('/admin/vendedores/edit/{vendedor}', [SellerController::class, 'edit'])->name('vendedores.edit');