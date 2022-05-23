<?php

namespace App\Repositories\Tenant\Category;

use App\Repositories\BaseRepository;
use App\Models\Tenant\Category\Category;

class CategoryRepository extends BaseRepository
{
  public function __construct(Category $model)
  {
    parent::__construct($model);
  }

  public static function make(): Self
  {
    return new self(new Category);
  }
}
