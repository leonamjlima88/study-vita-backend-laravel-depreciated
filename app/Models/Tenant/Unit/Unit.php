<?php

namespace App\Models\Tenant\Unit;

use App\Http\DataTransferObjects\Tenant\Unit\UnitDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Unit extends Model
{
    use HasFactory;
    use WithData;    

    protected $table = 'unit';
    protected $dates = [];
    protected $dataClass = UnitDto::class;
    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
    ];

    protected $fillable = [
        'abbreviation',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        // Formatar dados antes de salvar a informação
        static::saving(fn ($model) => $model);

        // Formatar dados após recuperar a informação
        static::retrieved(fn ($model) => $model);
    }
}
