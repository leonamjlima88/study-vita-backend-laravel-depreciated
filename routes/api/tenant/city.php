<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * City (Cidade)
 */
Route::group([
  'middleware' => [
    'api', 
    InitializeTenancyByDomain::class, 
    PreventAccessFromCentralDomains::class,
    'cors',
    'jwt',
    'acl',
    'X-Locale'
  ],
  'namespace' => 'App\Http\Controllers\Tenant\City',
  'prefix' => '',
], function () {
  Route::get("/city",         "CityController@index")->name("city.index");
  Route::get("/city/{id}",    "CityController@show")->name("city.show");
});