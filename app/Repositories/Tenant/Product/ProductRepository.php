<?php

namespace App\Repositories\Tenant\Product;

use App\Repositories\BaseRepository;
use App\Models\Tenant\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\Data;

class ProductRepository extends BaseRepository
{
  public function __construct(Product $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new Product);
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
        ->leftJoin('unit', 'unit.id', 'product.unit_id')
        ->leftJoin('category', 'category.id', 'product.category_id')
        ->leftJoin('brand', 'brand.id', 'product.brand_id'),
      'product.*, ' .
      'unit.abbreviation as unit_abbreviation, ' .
      'unit.description  as unit_description, ' .
      'category.name     as category_name, ' .
      'brand.name        as brand_name'
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
      ->with('unit')
      ->with('category')
      ->with('brand')
      ->first();

    return $modelFound
      ? $modelFound->getData()
      : null;
  }  
}
