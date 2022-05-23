<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Category (Categoria)
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
  'namespace' => 'App\Http\Controllers\Tenant\Category',
  'prefix' => '',
], function () {
  Route::get("/category",         "CategoryController@index")->name("category.index");
  Route::post("/category",        "CategoryController@store")->name("category.store");
  Route::get("/category/{id}",    "CategoryController@show")->name("category.show");
  Route::put("/category/{id}",    "CategoryController@update")->name("category.update");
  Route::delete("/category/{id}", "CategoryController@destroy")->name("category.destroy");
});