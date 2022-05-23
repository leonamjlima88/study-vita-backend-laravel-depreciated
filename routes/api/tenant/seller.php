<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Seller (Vendedores)
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
  'namespace' => 'App\Http\Controllers\Tenant\Seller',
  'prefix' => '',
], function () {
  Route::get("/seller",         "SellerController@index")->name("seller.index");
  Route::post("/seller",        "SellerController@store")->name("seller.store");
  Route::get("/seller/{id}",    "SellerController@show")->name("seller.show");
  Route::put("/seller/{id}",    "SellerController@update")->name("seller.update");
  Route::delete("/seller/{id}", "SellerController@destroy")->name("seller.destroy");
});