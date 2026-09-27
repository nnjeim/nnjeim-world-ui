<?php

use App\Http\Controllers\ComponentController;
use App\Support\ComponentCatalog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('/components', '/components/'.ComponentCatalog::DEFAULT_SLUG)
    ->name('components.index');

Route::get('/components/{component}', ComponentController::class)
    ->name('components.show');
