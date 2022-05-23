<?php

namespace App\Http\DataTransferObjects\Tenant\Category;

use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class CategoryDto extends Data
{
  public static function authorize(): bool
  {
    return true;
  }  

  public function __construct(
    #[Rule('nullable|integer')]
    public ?int $id,

    #[Rule('required|string|max:60')]
    public string $name,

    #[Rule('nullable|string|min:10')]
    public ?string $created_at,

    #[Rule('nullable|string|min:10')]
    public ?string $updated_at,
  ) {
  }

  // Preparar dados para validação
  public static function prepareForValidation(): void
  {
    request()->merge([]);
  }

  // Regras de validação
  public static function rules(): array
  {
    static::prepareForValidation();
    return [];
  }

  public static function withValidator(Validator $validator): void
  {
    $validator->after(function ($validator) {
      // $validator->errors()->add('filed', 'error');
    });
  }

  /**
   * Utilizado para formatar os dados caso seja necessário
   *
   * @return array
   */
  public function toResource(): array
  {
    return parent::toArray();
  }
}
