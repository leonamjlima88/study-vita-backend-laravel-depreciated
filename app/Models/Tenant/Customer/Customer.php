<?php

namespace App\Models\Tenant\Customer;

use App\Http\DataTransferObjects\Tenant\Customer\CustomerDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Customer extends Model
{
    use HasFactory;
    use WithData;
        
    protected $table = 'customer';
    protected $dates = [];
    protected $dataClass = CustomerDto::class;
    public $timestamps = true;

    protected $hidden = [
    ];

    protected $casts = [
        'icms_taxpayer' => 'boolean',
    ];

    protected $fillable = [
        'business_name',
        'alias_name',
        'ein',
        'state_registration',
        'icms_taxpayer',
        'municipal_registration',
        'note',
        'internet_page',
      ];

    protected static function boot()
    {
        parent::boot();
        
        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model->ein = onlyNumbers($model->ein ?? ''));

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);        
    }    

    public function customerAddress()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function customerContact()
    {
        return $this->hasMany(CustomerContact::class);
    }
}
