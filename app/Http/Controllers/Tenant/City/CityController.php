<?php

namespace App\Http\Controllers\Tenant\City;

use App\Http\Controllers\Controller;
use App\Services\Tenant\City\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
  public function __construct(
    protected CityService $service
  ) {
  }

  public function index(Request $request): JsonResponse
  {
    return $this->responseSuccess(
      $this->service->index(
        $request->input('page'),
        $request->input('filter'),
      )
    );
  }

  public function show(int $id): JsonResponse
  {
    return ($dto = $this->service->show($id))
      ? $this->responseSuccess($dto)
      : $this->responseError(code: Response::HTTP_NOT_FOUND);
  }  
}
