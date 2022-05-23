<?php

namespace App\Models\Central;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    public static function booted()
    {
        static::creating(function ($tenant) {
            $tenant->password = bcrypt($tenant->password);
            // $tenant->tenancy_db_name = env('DB_DATABASE').'_'.$tenant->domain;
        });
    }    
}