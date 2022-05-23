<?php

namespace App\Models\Tenant\User;

use App\Http\DataTransferObjects\Tenant\User\RoleDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\WithData;

class Role extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'role';
    protected $dates = [];
    protected $dataClass = RoleDto::class;
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

        // Formatar dados antes de recuperar a informação
        static::retrieved(fn ($model) => $model);
    }

    public function rolePermission()
    {
        return $this->hasMany(RolePermission::class);
    }
}
