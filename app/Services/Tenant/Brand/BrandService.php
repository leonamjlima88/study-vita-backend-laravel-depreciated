<?php

namespace App\Services\Tenant\Brand;

use App\Http\DataTransferObjects\Tenant\Brand\BrandDto;
use App\Repositories\Tenant\Brand\BrandRepository;
use App\Services\Tenant\User\RoleService;

class BrandService
{
  public function __construct(
    protected BrandRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(BrandRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): BrandDto|null
  {
    return $this->repository->show($id);
  }

  public function store(BrandDto $dto): BrandDto
  {
    return $this->repository->setTransaction(false)->store($dto);
  }

  public function update(int $id, BrandDto $dto): BrandDto
  {
    return $this->repository->setTransaction(false)->update($id, $dto);
  }

  public static function permissionTemplate(): array
  {
    return RoleService::permissionTemplateDefault('brand', 'Marcas');
  }
}
