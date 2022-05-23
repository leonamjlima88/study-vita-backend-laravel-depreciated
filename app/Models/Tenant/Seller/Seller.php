<?php

namespace App\Models\Tenant\Seller;

use App\Http\DataTransferObjects\Tenant\Seller\SellerDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Seller extends Model
{
    use HasFactory;
    use WithData;
        
    protected $table = 'seller';
    protected $dates = [];
    protected $dataClass = SellerDto::class;
    public $timestamps = true;

    protected $hidden = [
    ];

    protected $casts = [        
    ];

    protected $fillable = [
        'name',
        'ein',
        'note',
      ];

    protected static function boot()
    {
        parent::boot();
        
        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model->ein = onlyNumbers($model->ein ?? ''));

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);        
    }    

    public function sellerAddress()
    {
        return $this->hasMany(SellerAddress::class);
    }

    public function sellerContact()
    {
        return $this->hasMany(SellerContact::class);
    }
}
