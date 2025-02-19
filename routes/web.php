<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth/login');
});
Route::get('posts/getuser/{email}', [UserController::class, 'getUser'])->name('posts/getuser');
Route::get('/posts/getCourse', [ProductController::class, 'getCourse'])->name('posts.getCourse');
Route::get('/posts/data', [UserController::class, 'getData'])->name('posts.getData');
Route::get('/dashboard/{data}', action: [UserController::class, 'showcorse'])->name('dashboard');

Route::get('/showcorse/{data}', action: [UserController::class, 'showcorse'])->name('showcorse');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [ProductController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin/products');
    Route::get('/admin/products/create', [ProductController::class, 'create'])->name('admin/products/create');
    Route::post('/admin/products/save', [ProductController::class, 'save'])->name('admin/products/save');
    Route::get('/admin/products/edit/{id}', [ProductController::class, 'edit'])->name('admin/products/edit');
    Route::put('/admin/products/edit/{id}', [ProductController::class, 'update'])->name('admin/products/update');
    Route::get('/admin/products/delete/{id}', [ProductController::class, 'delete'])->name('admin/products/delete');
    Route::get('/admin/show', [UserController::class, 'show'])->name('admin/show');
    Route::get('/admin/addcourseuser/{emailluser}', [UserController::class, 'addcourseuser'])->name('admin/addcourseuser');
    Route::get('/admin/addmarkuser/{emailluser}', [UserController::class, 'addmarkuser'])->name('admin/addmarkuser');
    Route::get('/admin/assignmark/{email}/{corse}', [UserController::class, 'assignmark'])->name('admin/assignmark');
    Route::post('/admin/assign/', [UserController::class, 'assign'])->name('admin/assign');
    Route::post('/admin/addnmark/', [UserController::class, 'addnmark'])->name('admin/addnmark');

});


require __DIR__ . '/auth.php';
