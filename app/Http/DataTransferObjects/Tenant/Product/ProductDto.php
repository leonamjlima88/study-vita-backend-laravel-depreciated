<?php

namespace App\Http\DataTransferObjects\Tenant\Product;

use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class ProductDto extends Data
{
  public static function authorize(): bool
  {
    return true;
  }  

  public function __construct(
    #[Rule('nullable|integer')]
    public ?int $id,

    #[Rule('required|string|max:120')]
    public string $name,

    #[Rule('nullable|string|max:36')]
    public ?string $reference_code,

    #[Rule('nullable|string|max:36')]
    public ?string $ean_code,

    #[Rule('nullable|numeric|min:0')]
    public ?float $cost_price,

    #[Rule('nullable|numeric|min:0')]
    public ?float $sale_price,

    #[Rule('nullable|numeric|min:0')]
    public ?float $minimum_quantity,

    #[Rule('nullable|numeric|min:0')]
    public ?float $current_quantity,

    #[Rule('nullable|boolean')]
    public ?bool $move_stock,

    #[Rule('nullable|string')]
    public ?string $note,

    #[Rule('nullable|boolean')]
    public ?bool $discontinued,

    #[Rule('required|integer|exists:unit,id')]
    public int $unit_id,

    #[Rule('nullable')]
    public object|array|null $unit,

    #[Rule('nullable|integer|exists:category,id')]
    public ?int $category_id,

    #[Rule('nullable')]
    public object|array|null $category,

    #[Rule('nullable|integer|exists:brand,id')]
    public ?int $brand_id,

    #[Rule('nullable')]
    public object|array|null $brand,

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
