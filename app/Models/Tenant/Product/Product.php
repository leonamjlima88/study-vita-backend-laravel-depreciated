<?php

namespace App\Models\Tenant\Product;

use App\Http\DataTransferObjects\Tenant\Product\ProductDto;
use App\Models\Tenant\Brand\Brand;
use App\Models\Tenant\Category\Category;
use App\Models\Tenant\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Product extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'product';
    protected $dates = [];
    protected $dataClass = ProductDto::class;
    public $timestamps = true;

    protected $hidden = [
    ];

    protected $casts = [
        'cost_price' => 'float',
        'sale_price' => 'float',
        'minimum_quantity' => 'float',
        'current_quantity' => 'float',        
    ];

    protected $fillable = [
        'name',
        'reference_code',
        'ean_code',
        'cost_price',
        'sale_price',
        'minimum_quantity',
        'current_quantity',
        'move_product',
        'note',
        'discontinued',
        'unit_id',
        'category_id',
        'brand_id',
        'type',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model);

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
