<?php

namespace App\Http\DataTransferObjects\Tenant\Customer;

use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\Validator;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

class CustomerDto extends Data
{
  public static function authorize(): bool
  {
    return true;
  }

  public function __construct(
    #[Rule('nullable|integer')]
    public ?int $id,

    #[Rule('nullable|string|max:80')]
    public ?string $business_name,

    #[Rule('required|string|max:80')]
    public string $alias_name,

    public ?string $ein,

    #[Rule('nullable|string|max:20')]
    public ?string $state_registration,

    #[Rule('nullable|boolean')]
    public ?bool $icms_taxpayer,

    #[Rule('nullable|string|max:20')]
    public ?string $municipal_registration,

    #[Rule('nullable|string')]
    public ?string $note,

    #[Rule('nullable|string|max:255')]
    public ?string $internet_page,

    #[Rule('nullable|string|min:10')]
    public ?string $created_at,

    #[Rule('nullable|string|min:10')]
    public ?string $updated_at,

    /** @var CustomerAddressDto[] */
    public DataCollection $customer_address,

    /** @var CustomerContactDto[] */
    public DataCollection $customer_contact,
  ) {
  }

  // Preparar dados para validação
  public static function prepareForValidation(): void
  {
    request()->merge([
      'ein' => onlyNumbers(request('ein', '')),
    ]);
  }  

  public static function rules(): array
  {
    static::prepareForValidation();
    return [
      'ein' => [
        'required',
        'string',
        'numeric',
        ValidationRule::unique('customer', 'ein')->ignore(getRouteParameter(request()->route())),
        fn ($att, $value, $fail) => static::rulesEin($att, $value, $fail),
      ],
    ];
  }

  // Validar CPF/CNPJ
  public static function rulesEin($att, $value, $fail)
  {
    if ($value && (!cpfOrCnpjIsValid($value))) {
      $fail(trans('request_validation_lang.field_is_not_valid', ['value' => $value]));
    }
  }

  public static function withValidator(Validator $validator): void
  {
    $validator->after(function ($validator) {
      // CustomerAddress[]
      $addresses = request('customer_address');
      if (!$addresses) {
        // Endereço não pode ser nulo
        $validator->errors()->add('customer_address', trans('request_validation_lang.array_can_not_be_null'));
      } else {
        // Endereço deve conter um único registro como padrão.
        if (count(array_filter($addresses ?? [], fn ($i) => ($i['is_default'] ?? 0) == 1)) !== 1) {
          $validator->errors()->add('customer_address', trans('request_validation_lang.array_must_have_single_record_default'));
        }
      }
      
      // CustomerContact[]
      $contacts = request('customer_contact');
      if (!$contacts){
        // Contato não pode ser nulo
        $validator->errors()->add('customer_contact', trans('request_validation_lang.array_can_not_be_null'));
      } else {
        $contactsCountDefault = 0;
        foreach ($contacts as $key => $value) {
          $fieldName = 'customer_contact.' . $key . '.';

          // Documento ou Telefone ou Email precisa estar preenchido
          if ((!($value['name'] ?? ''))
          &&  (!($value['phone'] ?? ''))
          &&  (!($value['email'] ?? ''))
          ){
            $validator->errors()->add($fieldName . 'name|phone|email', trans('request_validation_lang.at_least_one_field_must_be_filled'));
          }

          // Contagem de registros com campo is_default=true
          if ($value['is_default'] ?? false) {
            $contactsCountDefault++;
          }
        }

        // Contato deve conter um único registro como padrão.
        if ($contactsCountDefault <> 1) {
          $validator->errors()->add('customer_contact', trans('request_validation_lang.array_must_have_single_record_default'));
        }
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
