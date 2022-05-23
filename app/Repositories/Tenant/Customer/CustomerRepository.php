<?php

namespace App\Repositories\Tenant\Customer;

use App\Repositories\BaseRepository;
use App\Models\Tenant\Customer\Customer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Data;

class CustomerRepository extends BaseRepository
{
  public function __construct(Customer $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new Customer);
  }

  /**
   * Método executado dentro de BaseRepository.index()
   * Adicionar join de tabelas e mostrar colunas específicas
   *
   * @param Builder $queryBuilder
   * @return array
   * Retornar um array contendo queryBuilder e string de colunas a serem exibidas
   */
  public function indexInside(Builder $queryBuilder): array
  {
    return [
      $queryBuilder
        ->leftJoin('customer_address', 'customer_address.customer_id', 'customer.id')
        ->leftJoin('customer_contact', 'customer_contact.customer_id', 'customer.id')
        ->leftJoin('city', 'city.id', 'customer_address.city_id')
        ->leftJoin('state', 'state.id', 'city.state_id')
        ->where('customer_address.is_default', '1')
        ->where('customer_contact.is_default', '1'),
      'customer.*, ' .
      'customer_address.zipcode         as customer_address_zipcode, ' .
      'customer_address.address         as customer_address_address, ' .
      'customer_address.address_number  as customer_address_address_number, ' .
      'customer_address.complement      as customer_address_complement, ' .
      'customer_address.district        as customer_address_district, ' .
      'customer_address.reference_point as customer_address_reference_point, ' .
      'customer_contact.name            as customer_contact_name, ' .
      'customer_contact.ein             as customer_contact_ein, ' .
      'customer_contact.type            as customer_contact_type, ' .
      'customer_contact.note            as customer_contact_note, ' .
      'customer_contact.phone           as customer_contact_phone, ' .
      'customer_contact.email           as customer_contact_email, ' .
      'city.id                        as city_id, ' .
      'city.name                      as city_name, ' .
      'city.ibge_code                 as city_ibge_code, ' .
      'state.name                     as state_name, ' .
      'state.abbreviation             as state_abbreviation'
    ];
  }

  /**
   * Localizar um único registro por ID
   * Acrescenta with para mostrar relacionamentos
   *
   * @param integer $id
   * @return Data|null
   */
  public function show(int $id): Data|null
  {
    $modelFound = $this->model
      ->whereId($id)
      ->with('customerAddress.city.state')
      ->with('customerContact')
      ->first();

    return $modelFound
      ? $modelFound->getData()
      : null;
  }

  /**
   * Salvar registro e retornar DTO
   * Acrescenta createMany para salvar relacionamentos
   * 
   * @param Data $dto
   * @return Data
   */
  public function store(Data $dto): Data
  {
    $dto->id = null;
    $data = $dto->toArray();
    $executeStore = function ($data) {
      $modelFound = $this->model->create($data);
      $modelFound->customerAddress()->createMany($data['customer_address']);
      $modelFound->customerContact()->createMany($data['customer_contact']);

      return $this->show($modelFound->id);
    };

    // Controle de Transação
    return match ($this->isTransaction()) {
      true => DB::transaction(fn () => $executeStore($data)),
      false => $executeStore($data),
    };
  }

  /**
   * Atualizar Registro e retorna DTO atualizado
   *
   * @param integer $id
   * @param Data $dto
   * @return Data
   */
  public function update(int $id, Data $dto): Data
  {
    $dto->id = $id;
    $data = $dto->toArray();
    $executeUpdate = function ($id, $data) {
      $modelFound = $this->model->findOrFail($id);

      // Atualizar Customer
      tap($modelFound)->update($data);

      // Atualizar CustomerAddress
      $modelFound->customerAddress()->delete();
      $modelFound->customerAddress()->createMany($data['customer_address']);

      // Atualizar CustomerContact
      $modelFound->customerContact()->delete();
      $modelFound->customerContact()->createMany($data['customer_contact']);

      return $this->show($modelFound->id);
    };

    // Controle de Transação
    return match ($this->isTransaction()) {
      true => DB::transaction(fn () => $executeUpdate($id, $data)),
      false => $executeUpdate($id, $data),
    };
  }
}