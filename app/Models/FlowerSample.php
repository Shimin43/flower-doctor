<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FlowerSample extends Model
{
    use HasFactory;

    protected $table = 'flower_samples';

    protected $fillable = [
        'sample_id',
        'farm_id',
        'farm_name',
        'farmer_name',
        'plot_id',
        'sample_date',
        'time_of_day',
        'lighting_condition',
        'environment_type',
        'location',
        'flower_species',
        'local_name',
        'scientific_name',
        'variety',
        'color',
        'plant_age_days',
        'growth_stage',
        'flower_count',
        'flower_diameter_cm',
        'stem_length_cm',
        'flower_weight_g',
        'health_status',
        'disease_status',
        'disease_name',
        'pest_status',
        'pest_name',
        'petal_damage',
        'freshness',
        'quality_grade',
        'maturity',
        'harvest_readiness',
        'soil_type',
        'temperature_c',
        'humidity_percent',
        'recent_rainfall',
        'sunlight_level',
        'cultivation_season',
        'weather_impact',
        'climate_impact',
        'total_plants',
        'flowers_harvested',
        'yield_kg',
        'production_cost_bdt',
        'cost_basis',
        'wholesale_price_bdt',
        'wholesale_price_unit',
        'retail_price_bdt',
        'retail_price_unit',
        'market_name',
        'demand_level',
        'highest_demand_season',
        'farmer_problems',
        'marketing_problems',
        'transport_problems',
        'storage_problems',
        'weather_climate_problems',
        'government_support',
        'government_support_details',
        'required_future_support',
    ];

    protected $casts = [
        'sample_date' => 'date:Y-m-d',
    ];

    /**
     * One flower sample can have many images.
     */
    public function images(): HasMany
    {
        return $this->hasMany(FlowerImage::class);
    }
}
