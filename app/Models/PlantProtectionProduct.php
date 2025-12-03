<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlantProtectionProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function plants(): BelongsToMany
    {
        return $this->belongsToMany(
            Plant::class,
            'plant_protection_product',
            'product_id',
            'plant_id'
        )->withPivot('dose')->withTimestamps();
    }
}
