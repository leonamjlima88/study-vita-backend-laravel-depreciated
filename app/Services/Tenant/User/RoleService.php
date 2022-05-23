<?php

namespace App\Services\Tenant\User;

use App\Http\DataTransferObjects\Tenant\User\RoleDto;
use App\Repositories\Tenant\User\RoleRepository;
use App\Services\Tenant\Brand\BrandService;
use App\Services\Tenant\Category\CategoryService;
use App\Services\Tenant\Customer\CustomerService;
use App\Services\Tenant\Product\ProductService;

class RoleService
{
  public function __construct(
    protected RoleRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(RoleRepository::make());
  }

  public function destroy(int $id): bool
  {
    return $this->repository->destroy($id);
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): RoleDto|null
  {
    return $this->repository->show($id);
  }

  public function store(RoleDto $dto): RoleDto
  {
    return $this->repository->setTransaction(true)->store($dto);
  }

  public function update(int $id, RoleDto $dto): RoleDto
  {
    return $this->repository->setTransaction(true)->update($id, $dto);
  }

  public function permissionTemplate(): array
  {
    return [
      ...BrandService::permissionTemplate(),
      ...CategoryService::permissionTemplate(),
      ...CustomerService::permissionTemplate(),
      ...ProductService::permissionTemplate(),
    ];    
  }

  /**
   * Template Padrão para facilitar cadastro de Permissões
   *
   * @param string $routeName
   * Utilize o mesmo nome da rota antes do ".".
   * Supondo que temos as seguintes rotas: 
   * Route::get("/customer", "customerController@index")->name("customer.store");
   * Route::get("/customer", "customerController@update")->name("customer.update");
   * Route::get("/customer", "customerController@destroy")->name("customer.destroy");
   * $routeName deve ser: customer 
   * O que está após o ponto se for .store, .update, .destroy, será adiconado como default
   * 
   * @param string $actionGroupDescription
   * Descrição do grupo de ações
   * Exemplo: Pessoas
   * 
   * @return array
   */
  public static function permissionTemplateDefault(string $routeName, string $actionGroupDescription): array 
  {
    $permissionTemplate = [
      [
        'action_name' => "${routeName}.formAccess",
        'action_group_description' => $actionGroupDescription,
        'action_name_description' => 'Acesso ao formulário',
        'is_allowed' => false
      ],
      [
        'action_name' => "${routeName}.store",
        'action_group_description' => $actionGroupDescription,
        'action_name_description' => 'Incluir',
        'is_allowed' => false
      ],
      [
        'action_name' => "${routeName}.update",
        'action_group_description' => $actionGroupDescription,
        'action_name_description' => 'Editar',
        'is_allowed' => false
      ],
      [
        'action_name' => "${routeName}.destroy",
        'action_group_description' => $actionGroupDescription,
        'action_name_description' => 'Deletar',
        'is_allowed' => false
      ],
    ];
    return $permissionTemplate;
  }
}
