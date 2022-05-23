<?php

namespace App\Models\Tenant\Opportunity;

use App\Models\Tenant\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunityProduct extends Model
{
    use HasFactory;

    protected $table = 'opportunity_product';
    public $timestamps = false;

    protected $casts = [
        'sale_quantity' => 'float',
        'sale_price' => 'float',
        'sale_amount' => 'float',
    ];

    protected $fillable = [
        'opportunity_id',
        'product_id',
        'sale_quantity',
        'sale_price',
        'sale_amount',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model);

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
