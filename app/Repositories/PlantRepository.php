<?php

namespace App\Repositories;

use App\Models\Plant;
use Illuminate\Database\Eloquent\Collection;

class PlantRepository implements PlantRepositoryInterface
{
    public function all(): Collection
    {
        return Plant::with(['type', 'protectionProducts'])->get();
    }
    
    public function find(int $id): ?Plant
    {
        return Plant::with(['type', 'protectionProducts'])->find($id);
    }
    
    public function create(array $data): Plant
    {
        $plant = Plant::create([
            'title' => $data['title'],
            'age' => $data['age'],
            'type_id' => $data['type_id'],
        ]);
        
        if (isset($data['protection_products'])) {
            $this->syncProtectionProducts($plant, $data['protection_products']);
        }
        
        return $plant->load(['type', 'protectionProducts']);
    }
    
    public function update(int $id, array $data): bool
    {
        $plant = Plant::find($id);
        
        if (!$plant) {
            return false;
        }
        
        $plant->update([
            'title' => $data['title'],
            'age' => $data['age'],
            'type_id' => $data['type_id'],
        ]);
        
        if (isset($data['protection_products'])) {
            $this->syncProtectionProducts($plant, $data['protection_products']);
        }
        
        return true;
    }
    
    public function delete(int $id): bool
    {
        $plant = Plant::find($id);
        
        if (!$plant) {
            return false;
        }
        
        $plant->protectionProducts()->detach();
        return $plant->delete();
    }
    
    private function syncProtectionProducts(Plant $plant, array $products): void
    {
        $syncData = [];
        
        foreach ($products as $product) {
            $syncData[$product['id']] = ['dose' => $product['dose']];
        }
        
        $plant->protectionProducts()->sync($syncData);
    }
}
