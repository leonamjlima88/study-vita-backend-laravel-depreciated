<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Customer (Clientes)
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
  'namespace' => 'App\Http\Controllers\Tenant\Customer',
  'prefix' => '',
], function () {
  Route::get("/customer",         "CustomerController@index")->name("customer.index");
  Route::post("/customer",        "CustomerController@store")->name("customer.store");
  Route::get("/customer/{id}",    "CustomerController@show")->name("customer.show");
  Route::put("/customer/{id}",    "CustomerController@update")->name("customer.update");
  Route::delete("/customer/{id}", "CustomerController@destroy")->name("customer.destroy");
});