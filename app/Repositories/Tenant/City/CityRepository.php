<?php

namespace App\Repositories\Tenant\City;

use App\Repositories\BaseRepository;
use App\Models\Tenant\City\City;
use Illuminate\Database\Eloquent\Builder;
use Spatie\LaravelData\Data;

class CityRepository extends BaseRepository
{
  public function __construct(City $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new City);
  }

  /**
   * Método executado dentro de BaseRepository.index()
   * Adicionar join de tabelas e mostrar colunas específicas
   *
   * @param Builder $queryBuilder
   * @return array
   */
  public function indexInside(Builder $queryBuilder): array
  {
    return [
      $queryBuilder->leftJoin('state', 'state.id', 'city.state_id'),
      'city.*, ' .
      'state.name         as state_name,' .
      'state.abbreviation as state_abbreviation'
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
      ->with('state')
      ->first();

    return $modelFound 
      ? $modelFound->getData()
      : null;
  }
}
