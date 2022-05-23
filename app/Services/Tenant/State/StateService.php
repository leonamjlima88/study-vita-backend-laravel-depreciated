<?php

namespace App\Services\Tenant\State;

use App\Http\DataTransferObjects\Tenant\State\StateDto;
use App\Repositories\Tenant\State\StateRepository;

class StateService
{
  public function __construct(
    protected StateRepository $repository
  ) {
  }

  public static function make(): Self
  {
    return new self(StateRepository::make());
  }

  public function index(array|null $page = [], array|null $filter = [], array|null $filterEx = []): array
  {
    return $this->repository->index($page, $filter, $filterEx);
  }

  public function show(int $id): StateDto|null
  {
    return $this->repository->show($id);
  }
}
