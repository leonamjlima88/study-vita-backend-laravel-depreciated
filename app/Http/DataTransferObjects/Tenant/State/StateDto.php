<?php

namespace App\Http\DataTransferObjects\Tenant\State;

use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class StateDto extends Data
{
  public static function authorize(): bool
  {
    return true;
  }  

  public function __construct(
    #[Rule('nullable|integer')]
    public ?int $id,

    #[Rule('required|string|max:50')]
    public string $name,

    #[Rule('required|string|max:2')]
    public string $abbreviation,
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
