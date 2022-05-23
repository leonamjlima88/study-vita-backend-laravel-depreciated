<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Teste de conexão com o Tenant
 */
Route::group([
    'middleware' => [
        'api',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ],
], function () {
    Route::get('/ping', function () {
        return 'pong [TENANT]';
    });
});

/**
 * Who am i? (Tenant Conectado)
 */
Route::group([
    'middleware' => [
        'api', 
        InitializeTenancyByDomain::class, 
        PreventAccessFromCentralDomains::class,
        'cors',
        'X-Locale'
    ],
], function () {
    Route::get('/whoami', function () {
        return responseSuccess([
            "iam" => [
                "id" => tenant('id'),
                "email" => tenant('email'),
                "domain" => tenant('domain'),
                "company" => tenant('company'),
                "tenancy_db_name" => tenant('tenancy_db_name'),
                "created_at" => tenant('created_at'),
            ]
        ]);
    });
});