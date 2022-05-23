<?php

namespace App\Services\Tenant\Seller;

use App\Http\DataTransferObjects\Tenant\Seller\SellerDto;
use App\Repositories\Tenant\Seller\SellerRepository;
use App\Services\Tenant\User\RoleService;

class SellerService
{
  public function __construct(
    protected SellerRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(SellerRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): SellerDto|null
  {
    return $this->repository->show($id);
  }

  public function store(SellerDto $dto): SellerDto|null
  {
    return $this->repository->setTransaction(true)->store($dto);
  }

  public function update(int $id, SellerDto $dto): SellerDto
  {
    return $this->repository->setTransaction(true)->update($id, $dto);
  }

  public static function permissionTemplate(): array
  {
    return RoleService::permissionTemplateDefault('seller', 'Vendedores');
  }  
}