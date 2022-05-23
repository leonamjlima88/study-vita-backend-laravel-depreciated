<?php

use Illuminate\Support\Facades\Route;

/**
 * Tenants (Inquilinos)
 */
Route::group([
    'middleware' => ['api', 'cors', 'X-Locale'],
    'namespace' => 'App\Http\Controllers\Central',
    'prefix' => '',
], function () {
    Route::get("/tenant",         "TenantController@index")->name("tenant.index");
    Route::post("/tenant",        "TenantController@store")->name("tenant.store");
    Route::get("/tenant/{id}",    "TenantController@show")->name("tenant.show");
    Route::put("/tenant/{id}",    "TenantController@update")->name("tenant.update");
    Route::delete("/tenant/{id}", "TenantController@destroy")->name("tenant.destroy");
});
