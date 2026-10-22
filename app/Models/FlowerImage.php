<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlowerImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'flower_sample_id',
        'image_path',
        'image_url',
        'image_angle',
        'lighting_condition',
        'plant_part',
        'image_quality',
        'predicted_flower_species',
        'predicted_disease',
        'prediction_confidence',
    ];

    protected $casts = [
        'prediction_confidence' => 'decimal:2',
    ];

    /**
     * Each image belongs to one flower sample.
     */
    public function flowerSample(): BelongsTo
    {
        return $this->belongsTo(FlowerSample::class);
    }
}
