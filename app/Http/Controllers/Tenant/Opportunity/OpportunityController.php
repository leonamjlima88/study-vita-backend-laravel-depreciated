<?php

namespace App\Http\Controllers\Tenant\Opportunity;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\Tenant\Opportunity\OpportunityDto;
use App\Services\Tenant\Opportunity\OpportunityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OpportunityController extends Controller
{
  public function __construct(
    protected OpportunityService $service
  ) {
  }

  public function destroy(int $id): JsonResponse
  {
    return $this->service->destroy($id)
      ? $this->responseSuccess(code: Response::HTTP_NO_CONTENT)
      : $this->responseError(code: Response::HTTP_NOT_FOUND);
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

  public function store(OpportunityDto $dto): JsonResponse
  {
    return $this->responseSuccess(
      $this->service->store($dto),
      Response::HTTP_CREATED
    );
  }

  public function update(OpportunityDto $dto, int $id): JsonResponse
  {
    return $this->responseSuccess(
      $this->service->update($id, $dto)
    );
  }
}
