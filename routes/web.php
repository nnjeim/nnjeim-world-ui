<?php

use App\Http\Controllers\ComponentController;
use App\Support\ComponentCatalog;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

$publicPageCache = SetCacheHeaders::using([
    'public' => true,
    'max_age' => 300,
    's_maxage' => 3600,
    'stale_while_revalidate' => 86400,
    'etag' => true,
]);

$statefulWebMiddleware = [
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    ShareErrorsFromSession::class,
    PreventRequestForgery::class,
];

Route::middleware($publicPageCache)
    ->withoutMiddleware($statefulWebMiddleware)
    ->group(function (): void {
        Route::view('/', 'welcome')->name('home');

        Route::get('/components', fn () => view('components.index', [
            'components' => ComponentCatalog::all(),
        ]))->name('components.index');

        Route::get('/components/{component}', ComponentController::class)
            ->name('components.show');
    });
