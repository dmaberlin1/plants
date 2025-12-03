<?php

namespace App\Repositories;


use App\Models\Plant;
use Illuminate\Database\Eloquent\Collection;

interface PlantRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Plant;

    public function create(array $data): Plant;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
