<?php

namespace App\Models\Tenant\Category;

use App\Http\DataTransferObjects\Tenant\Category\CategoryDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Category extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'category';
    protected $dates = [];
    protected $dataClass = CategoryDto::class;
    public $timestamps = true;

    protected $hidden = [
    ];

    protected $casts = [
    ];

    protected $fillable = [
        'name',
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
