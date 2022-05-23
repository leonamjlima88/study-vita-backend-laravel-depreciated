<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\TenantRequest;
use App\Models\Central\Tenant;

class TenantController extends Controller
{
    public function destroy()
    {
        dd('destroy');
    }

    public function index()
    {
        dd('index');
    }

    public function show()
    {
        dd('show');
    }


    public function store(TenantRequest $request)
    {
        $tenant = Tenant::create($request->validated());
        $tenant->createDomain(['domain' => $request->domain]);
    }

    public function update()
    {
        dd('update');
    }
}
