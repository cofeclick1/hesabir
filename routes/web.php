<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryOptionController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/persons/create', [PersonController::class, 'create'])->name('persons.create');
Route::post('/persons', [PersonController::class, 'store'])->name('persons.store');
// برای دریافت آخرین کد حسابداری (AJAX)
Route::get('/persons/latest-code', [PersonController::class, 'latestCode'])->name('persons.latestCode');
Route::get('/persons/create', [PersonController::class, 'create'])->name('persons.create');
Route::post('/persons', [PersonController::class, 'store'])->name('persons.store');

Route::get('/categories/ajax-search', [CategoryController::class, 'ajaxSearch']);
Route::post('/categories/ajax-create', [CategoryController::class, 'ajaxCreate']);
// برای دریافت آخرین کد حسابداری (AJAX)

// برای افزودن دسته‌بندی جدید (AJAX)
Route::get('/categories-list', [CategoryController::class, 'list'])->name('categories.list');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

Route::resource('category-options', CategoryOptionController::class)->only([
    'index', 'store', 'update', 'destroy'
]);


Route::get('/category-options', [CategoryOptionController::class, 'index']);
Route::post('/category-options', [CategoryOptionController::class, 'store']);
Route::put('/category-options/{id}', [CategoryOptionController::class, 'update']);
Route::delete('/category-options/{id}', [CategoryOptionController::class, 'destroy']);


require __DIR__.'/auth.php';
