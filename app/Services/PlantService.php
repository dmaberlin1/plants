<?php

namespace App\Services;

use App\Repositories\PlantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Plant;

class PlantService
{
    public function __construct(
        private readonly PlantRepositoryInterface $plantRepository
    ) {}

    public function getAllPlants(): Collection
    {
        return $this->plantRepository->all();
    }

    public function getPlantById(int $id): ?Plant
    {
        return $this->plantRepository->find($id);
    }

    public function createPlant(array $data): Plant
    {
        return $this->plantRepository->create($data);
    }

    public function updatePlant(int $id, array $data): bool
    {
        return $this->plantRepository->update($id, $data);
    }

    public function deletePlant(int $id): bool
    {
        return $this->plantRepository->delete($id);
    }
}
