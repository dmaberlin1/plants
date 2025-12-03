<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlantRequest;
use App\Http\Requests\UpdatePlantRequest;
use App\Http\Resources\PlantResource;
use App\Services\PlantService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PlantController extends Controller
{
    public function __construct(
        private readonly PlantService $plantService
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $plants = $this->plantService->getAllPlants();
        return PlantResource::collection($plants);
    }

    public function show(int $id): PlantResource|JsonResponse
    {
        $plant = $this->plantService->getPlantById($id);

        if (!$plant) {
            return response()->json(['message' => 'Plant not found'], 404);
        }

        return new PlantResource($plant);
    }

    public function store(StorePlantRequest $request): PlantResource
    {
        $plant = $this->plantService->createPlant($request->validated());
        return new PlantResource($plant);
    }

    public function update(UpdatePlantRequest $request, int $id): PlantResource|JsonResponse
    {
        $updated = $this->plantService->updatePlant($id, $request->validated());

        if (!$updated) {
            return response()->json(['message' => 'Plant not found'], 404);
        }

        $plant = $this->plantService->getPlantById($id);
        return new PlantResource($plant);
    }

    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->plantService->deletePlant($id);

        if (!$deleted) {
            return response()->json(['message' => 'Plant not found'], 404);
        }

        return response()->json(['message' => 'Plant deleted successfully']);
    }
}
