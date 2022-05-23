<?php

namespace App\Models\Tenant\City;

use App\Http\DataTransferObjects\Tenant\City\CityDto;
use App\Models\Tenant\State\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class City extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'city';
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $dataClass = CityDto::class;
    public $timestamps = true;

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'ibge_code',
        'state_id',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model);

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);
    }
    
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
