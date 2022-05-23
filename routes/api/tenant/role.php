<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/**
 * Role (Perfl de usuários)
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
  'namespace' => 'App\Http\Controllers\Tenant\User',
  'prefix' => '',
], function () {
  Route::get("/role/permission-template", "RoleController@permissionTemplate")->name("role.permissionTemplate");
  Route::get("/role",                     "RoleController@index")->name("role.index");
  Route::post("/role",                    "RoleController@store")->name("role.store");
  Route::get("/role/{id}",                "RoleController@show")->name("role.show");
  Route::put("/role/{id}",                "RoleController@update")->name("role.update");
  Route::delete("/role/{id}",             "RoleController@destroy")->name("role.destroy");
});