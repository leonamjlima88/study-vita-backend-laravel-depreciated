<?php

namespace App\Repositories\Tenant\Opportunity;

use App\Repositories\BaseRepository;
use App\Models\Tenant\Opportunity\Opportunity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelData\Data;

class OpportunityRepository extends BaseRepository
{
  public function __construct(Opportunity $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new Opportunity);
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
        ->leftJoin('customer', 'customer.id', 'opportunity.customer_id')
        ->leftJoin('seller', 'seller.id', 'opportunity.seller_id')
        ->withSum('opportunityProduct', 'sale_amount')
        ->withSum('opportunityProduct', 'sale_quantity'),
      'opportunity.*, ' .
      'customer.business_name as customer_business_name, ' .
      'customer.alias_name    as customer_alias_name, ' .
      'customer.ein           as customer_ein, ' .
      'seller.name            as seller_name ',
    ];
  }

  /**
   * Localizar um único registro por ID
   * Acrescenta with para mostrar relacionamentos
   * 
   * Observação: Eu poderia trazer todos os relacionamentos no método show,
   * porém, para evitar selects desnecessários no banco de dados, buscarei apenas os relacionamentos que preciso
   * Exemplo abaixo se fosse para trazer todos os relacionamentos
   *
   * $modelFound = $this->model
   *   ->whereId($id)
   *   ->with('customer.customerAddress.city.state')
   *   ->with('customer.customerContact')
   *   ->with('seller.sellerAddress.city.state')
   *   ->with('seller.sellerContact')
   *   ->with('opportunityProduct.product.unit')
   *   ->with('opportunityProduct.product.brand')
   *   ->first();
   *
   * @param integer $id
   * @return Data|null
   */
  public function show(int $id): Data|null
  {
    // Buscando apenas os campos que preciso
    $modelFound = $this->model
      ->whereId($id)
      ->with('customer:id,business_name,alias_name,ein')
      ->with('seller:id,name')      
      ->with('opportunityProduct.product:id,name')      
      ->withSum('opportunityProduct as opportunity_product_sum_sale_amount', 'sale_amount')
      ->withSum('opportunityProduct as opportunity_product_sum_sale_quantity', 'sale_quantity')
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
      $modelFound->opportunityProduct()->createMany($data['opportunity_product']);

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

      // Atualizar Opportunity
      tap($modelFound)->update($data);

      // Atualizar OpportunityAddress
      $modelFound->opportunityProduct()->delete();
      $modelFound->opportunityProduct()->createMany($data['opportunity_product']);

      return $this->show($modelFound->id);
    };

    // Controle de Transação
    return match ($this->isTransaction()) {
      true => DB::transaction(fn () => $executeUpdate($id, $data)),
      false => $executeUpdate($id, $data),
    };
  }
}