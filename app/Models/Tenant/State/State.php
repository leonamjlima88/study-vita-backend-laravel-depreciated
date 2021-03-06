<?php

namespace App\Models\Tenant\State;

use App\Http\DataTransferObjects\Tenant\State\StateDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class State extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'state';
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];
    protected $dataClass = StateDto::class;
    public $timestamps = true;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $fillable = [
        'name',
        'abbreviation',
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
