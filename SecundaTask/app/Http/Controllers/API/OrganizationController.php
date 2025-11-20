<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\SearchByActivityRequest;
use App\Http\Requests\Organization\SearchByBuildingRequest;
use App\Http\Requests\Organization\SearchByNameRequest;
use App\Http\Requests\Organization\SearchNearbyRequest;
use App\Http\Responses\ApiResponse;
use App\Services\OrganizationService;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    protected OrganizationService $service;

    public function __construct(OrganizationService $service)
    {
        $this->service = $service;
    }

    
    public function show(int $id): JsonResponse
    {
        $data = $this->service->getById($id);

        return ApiResponse::success($data, 'Организация по введенному ID найдена!');
    }


    public function byActivity(SearchByActivityRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = $this->service->getByActivity($validated);

        return ApiResponse::success($data, 'Организации по введенной активности найдены!');
    }


    public function byBuilding(SearchByBuildingRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $data = $this->service->getByBuilding($validated);

        return ApiResponse::success($data, 'Организации в этом здании найдены!');
    }


    public function byName(SearchByNameRequest $request): JsonResponse
    {
        $validated = $request->validated()['name'];
  
        $data = $this->service->getByName($validated);

        return ApiResponse::success($data, 'Организация с введенным названием найдена!');
    }


    public function byGeo(SearchNearbyRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $data = $this->service->getByGeo($validated);

        return ApiResponse::success($data, 'Организации в данной области найдены!');
    }
}
