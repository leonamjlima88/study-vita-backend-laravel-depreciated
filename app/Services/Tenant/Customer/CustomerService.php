<?php

namespace App\Services\Tenant\Customer;

use App\Http\DataTransferObjects\Tenant\Customer\CustomerDto;
use App\Repositories\Tenant\Customer\CustomerRepository;
use App\Services\Tenant\User\RoleService;

class CustomerService
{
  public function __construct(
    protected CustomerRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(CustomerRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): CustomerDto|null
  {
    return $this->repository->show($id);
  }

  public function store(CustomerDto $dto): CustomerDto|null
  {
    return $this->repository->setTransaction(true)->store($dto);
  }

  public function update(int $id, CustomerDto $dto): CustomerDto
  {
    return $this->repository->setTransaction(true)->update($id, $dto);
  }

  public static function permissionTemplate(): array
  {
    return RoleService::permissionTemplateDefault('customer', 'Clientes');
  }  
}