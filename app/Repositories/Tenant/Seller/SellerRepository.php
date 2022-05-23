<?php

namespace App\Repositories\Tenant\Seller;

use App\Repositories\BaseRepository;
use App\Models\Tenant\Seller\Seller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Data;

class SellerRepository extends BaseRepository
{
  public function __construct(Seller $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new Seller);
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
        ->leftJoin('seller_address', 'seller_address.seller_id', 'seller.id')
        ->leftJoin('seller_contact', 'seller_contact.seller_id', 'seller.id')
        ->leftJoin('city', 'city.id', 'seller_address.city_id')
        ->leftJoin('state', 'state.id', 'city.state_id')
        ->where('seller_address.is_default', '1')
        ->where('seller_contact.is_default', '1'),
      'seller.*, ' .
      'seller_address.zipcode         as seller_address_zipcode, ' .
      'seller_address.address         as seller_address_address, ' .
      'seller_address.address_number  as seller_address_address_number, ' .
      'seller_address.complement      as seller_address_complement, ' .
      'seller_address.district        as seller_address_district, ' .
      'seller_address.reference_point as seller_address_reference_point, ' .
      'seller_contact.name            as seller_contact_name, ' .
      'seller_contact.ein             as seller_contact_ein, ' .
      'seller_contact.type            as seller_contact_type, ' .
      'seller_contact.note            as seller_contact_note, ' .
      'seller_contact.phone           as seller_contact_phone, ' .
      'seller_contact.email           as seller_contact_email, ' .
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
      ->with('sellerAddress.city.state')
      ->with('sellerContact')
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
      $modelFound->sellerAddress()->createMany($data['seller_address']);
      $modelFound->sellerContact()->createMany($data['seller_contact']);

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

      // Atualizar Seller
      tap($modelFound)->update($data);

      // Atualizar SellerAddress
      $modelFound->sellerAddress()->delete();
      $modelFound->sellerAddress()->createMany($data['seller_address']);

      // Atualizar SellerContact
      $modelFound->sellerContact()->delete();
      $modelFound->sellerContact()->createMany($data['seller_contact']);

      return $this->show($modelFound->id);
    };

    // Controle de Transação
    return match ($this->isTransaction()) {
      true => DB::transaction(fn () => $executeUpdate($id, $data)),
      false => $executeUpdate($id, $data),
    };
  }
}