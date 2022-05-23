<?php

namespace App\Services\Tenant\Opportunity;

use App\Http\DataTransferObjects\Tenant\Opportunity\OpportunityDto;
use App\Repositories\Tenant\Opportunity\OpportunityRepository;
use App\Services\Tenant\User\RoleService;

class OpportunityService
{
  public function __construct(
    protected OpportunityRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(OpportunityRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): OpportunityDto|null
  {
    return $this->repository->show($id);
  }

  public function store(OpportunityDto $dto): OpportunityDto|null
  {
    $this->beforeSave($dto);
    return $this->repository->setTransaction(true)->store($dto);
  }

  public function update(int $id, OpportunityDto $dto): OpportunityDto
  {
    $this->beforeSave($dto);
    return $this->repository->setTransaction(true)->update($id, $dto);
  }

  public static function permissionTemplate(): array
  {
    return RoleService::permissionTemplateDefault('opportunity', 'Oportunidades');
  }

  public function beforeSave(OpportunityDto $dto)
  {
    // Calcular total dos produtos
    foreach ($dto->opportunity_product as $key => $value) {
      $value->sale_amount = $value->sale_quantity * $value->sale_price;
    }
  }
}