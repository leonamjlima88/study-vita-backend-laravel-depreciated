<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/**
 * Teste de conexão com a Central
 */
Route::get('/ping', function () {
    return 'pong [CENTRAL]';
});

// Limpar cache
Route::group([], function () {
    Route::get('/clear-cache', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Cache::flush();
        return "Cache is cleared";
    });
});