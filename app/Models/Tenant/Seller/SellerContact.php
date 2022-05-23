<?php

namespace App\Models\Tenant\Seller;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerContact extends Model
{
    use HasFactory;

    protected $table = 'seller_contact';
    public $timestamps = false;

    protected $casts = [
        'is_default' => 'boolean',
    ];

    protected $fillable = [
        'seller_id',
        'is_default',
        'name',
        'ein',
        'type',
        'note',
        'phone',
        'email',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model->ein = onlyNumbers($model->ein));

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model->ein = formatCpfCnpj($model->ein));
    }    
}
