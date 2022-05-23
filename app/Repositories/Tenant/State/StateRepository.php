<?php

namespace App\Repositories\Tenant\State;

use App\Repositories\BaseRepository;
use App\Models\Tenant\State\State;

class StateRepository extends BaseRepository
{
  public function __construct(State $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new State);
  }
}
