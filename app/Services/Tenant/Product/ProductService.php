<?php

namespace App\Services\Tenant\Product;

use App\Http\DataTransferObjects\Tenant\Product\ProductDto;
use App\Repositories\Tenant\Product\ProductRepository;
use App\Services\Tenant\User\RoleService;

class ProductService
{
  public function __construct(
    protected ProductRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(ProductRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): ProductDto|null
  {
    return $this->repository->show($id);
  }

  public function store(ProductDto $dto): ProductDto
  {
    return $this->repository->setTransaction(false)->store($dto);
  }

  public function update(int $id, ProductDto $dto): ProductDto
  {
    return $this->repository->setTransaction(false)->update($id, $dto);
  }

  public static function permissionTemplate(): array
  {
    return RoleService::permissionTemplateDefault('product', 'Produtos / Serviços');
  }  
}