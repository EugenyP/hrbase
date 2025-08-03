<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
/*
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
*/
Route::middleware('auth')->group(function () {
	Route::get('/', DashboardController::class)->name('dashboard');

	Route::get('/users', [UserController::class, 'index'])->name('users');
	Route::get('/users/new', [UserController::class, 'create'])->name('users.create');
	Route::post('/users/new', [UserController::class, 'store'])->name('users.store');
	Route::get('/users/{user}', [UserController::class, 'edit'])->name('users.edit');
	Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

	Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
	Route::get('/categories/new', [CategoryController::class, 'create'])->name('category.create');
	Route::post('/categories/new', [CategoryController::class, 'store'])->name('category.store');
	Route::get('/categories/{category}', [CategoryController::class, 'edit'])->name('category.edit');
	Route::patch('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');

    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
	Route::delete('/tags/{tag}', [TagController::class, 'delete'])->name('tags.delete');

    Route::get('/persons', [PersonController::class, 'index'])->name('person.index');
	Route::get('/persons/new', [PersonController::class, 'create'])->name('person.create');
	Route::post('/persons/new', [PersonController::class, 'store'])->name('person.store');
    Route::get('/persons/{person}/edit/projects/new', [ProjectController::class, 'create'])->name('persons.edit.projects.new');
    Route::post('/persons/{person}/edit/projects/new', [ProjectController::class, 'store'])->name('persons.edit.projects.store');
    Route::get('/persons/{person}/edit/projects/{project}', [ProjectController::class, 'edit'])->name('persons.edit.projects.edit');
    Route::patch('/persons/{person}/edit/projects/{project}', [ProjectController::class, 'update'])->name('persons.edit.projects.update');
    Route::get('/persons/{person}/edit/projects', [ProjectController::class, 'index'])->name('persons.edit.projects');
    Route::get('/persons/{person}/edit', [PersonController::class, 'edit'])->name('person.edit');
    Route::patch('/persons/{person}/edit', [PersonController::class, 'update'])->name('person.update');
    Route::get('/persons/{person}', [PersonController::class, 'show'])->name('person.show');
    Route::delete('/persons/{person}', [PersonController::class, 'delete'])->name('person.delete');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

	Route::get('api/tags', [TagController::class, 'search']);
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

