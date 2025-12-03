<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'age',
        'type_id',
    ];

    protected $casts = [
        'age' => 'integer',
        'type_id' => 'integer',
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(PlantType::class, 'type_id');
    }

    public function protectionProducts(): BelongsToMany
    {
        return $this->belongsToMany(
            PlantProtectionProduct::class,
            'plant_protection_product',
            'plant_id',
            'product_id'
        )->withPivot('dose')->withTimestamps();
    }
}
