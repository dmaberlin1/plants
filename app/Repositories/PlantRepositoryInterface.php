<?php

namespace App\Repositories;


use App\Models\Plant;

interface PlantRepositoryInterface
{
    public function all();
    
    public function find(int $id): ?Plant;
    
    public function create(array $data): Plant;
    
    public function update(int $id, array $data): bool;
    
    public function delete(int $id): bool;
}
