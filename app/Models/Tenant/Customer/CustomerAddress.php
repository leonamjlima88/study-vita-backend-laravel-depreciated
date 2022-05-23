<?php

namespace App\Models\Tenant\Customer;

use App\Models\Tenant\City\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $table = 'customer_address';
    public $timestamps = false;
    protected $hidden = [];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected $fillable = [
        'customer_id',
        'is_default',
        'zipcode',
        'address',
        'address_number',
        'complement',
        'district',
        'city_id',
        'reference_point',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model);

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
