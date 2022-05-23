<?php

namespace App\Http\DataTransferObjects\Tenant\Opportunity;

use App\Models\Tenant\Opportunity\Enum\OpportunityApprovalEnum;
use App\Models\Tenant\Opportunity\Enum\OpportunityStatusEnum;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class OpportunityDto extends Data
{
  public static function authorize(): bool
  {
    return true;
  }

  public function __construct(
    #[Rule('nullable|integer')]
    public ?int $id,

    #[Rule('required|integer|exists:customer,id')]
    public int $customer_id,

    #[Rule('nullable')]
    public object|array|null $customer,

    #[Rule('required|integer|exists:seller,id')]
    public int $seller_id,

    #[Rule('nullable')]
    public object|array|null $seller,

    public int $status,

    public int $approval,

    #[Rule('nullable|numeric')]
    public ?float $opportunity_product_sum_sale_quantity,

    #[Rule('nullable|numeric')]
    public ?float $opportunity_product_sum_sale_amount,

    /** @var OpportunityProductDto[] */
    public DataCollection $opportunity_product,
  ) {
  }

  public static function rules(): array
  {
    return [
      'status' => ['required', 'integer', ValidationRule::in([0,1,2])],
      'approval' => ['required', 'integer', ValidationRule::in([0,1,2])],
    ];
  }

  public static function withValidator(Validator $validator): void
  {
    $validator->after(function ($validator) {
      $products = request('opportunity_product', null);
      if (!$products) {
        $validator->errors()->add('opportunity_product', trans('request_validation_lang.array_can_not_be_null'));
      }
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
