<?php

namespace App\Services\Tenant\Category;

use App\Http\DataTransferObjects\Tenant\Category\CategoryDto;
use App\Repositories\Tenant\Category\CategoryRepository;
use App\Services\Tenant\User\RoleService;

class CategoryService
{
  public function __construct(
    protected CategoryRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(CategoryRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): CategoryDto|null
  {
    return $this->repository->show($id);
  }

  public function store(CategoryDto $dto): CategoryDto
  {
    return $this->repository->setTransaction(false)->store($dto);
  }

  public function update(int $id, CategoryDto $dto): CategoryDto
  {
    return $this->repository->setTransaction(false)->update($id, $dto);
  }

  public static function permissionTemplate(): array
  {
    return RoleService::permissionTemplateDefault('category', 'Categorias');
  }  
}
