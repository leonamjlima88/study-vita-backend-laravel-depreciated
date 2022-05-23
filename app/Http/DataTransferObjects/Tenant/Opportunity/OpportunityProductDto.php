<?php

namespace App\Http\DataTransferObjects\Tenant\Opportunity;

use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class OpportunityProductDto extends Data
{
  public static function authorize(): bool
  {
    return true;
  }  

  public function __construct(
    #[Rule('nullable|integer')]
    public ?int $id,

    #[Rule('nullable|integer')]
    public ?int $opportunity_id,

    #[Rule('required|integer|exists:product,id')]
    public int $product_id,

    #[Rule('nullable')]
    public object|array|null $product,

    #[Rule('nullable|numeric|min:0')]
    public ?float $sale_quantity,

    #[Rule('nullable|numeric|min:0')]
    public ?float $sale_price,    

    #[Rule('nullable|numeric|min:0')]
    public ?float $sale_amount,
  ) {
  }
}
