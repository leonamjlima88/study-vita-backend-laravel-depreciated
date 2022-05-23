<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Auth
 */
Route::group([
    'middleware' => [
        'api', 
        InitializeTenancyByDomain::class, 
        PreventAccessFromCentralDomains::class,
        'cors',
        'X-Locale'
    ],
    'namespace' => 'App\Http\Controllers\Tenant\Auth',
    'prefix' => 'auth',
], function () {
    Route::post('/login', 'AuthController@login');
    Route::middleware('jwt')->post('/logout', 'AuthController@logout');
    Route::middleware('jwt')->post('/refresh', 'AuthController@refresh');
    Route::middleware('jwt')->post('/me', 'AuthController@me');    
});