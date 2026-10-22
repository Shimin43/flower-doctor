
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flower_samples', function (Blueprint $table) {
            $table->string('sample_id')->unique();
            $table->string('farm_id')->nullable();
            $table->string('farm_name')->nullable();
            $table->string('farmer_name')->nullable();
            $table->string('plot_id')->nullable();
            $table->date('sample_date')->nullable();
            $table->string('time_of_day')->nullable();
            $table->string('lighting_condition')->nullable();
            $table->string('environment_type')->nullable();
            $table->string('location')->nullable();
            $table->string('flower_species');
            $table->string('local_name')->nullable();
            $table->string('scientific_name')->nullable();
            $table->string('variety')->nullable();
            $table->string('color')->nullable();
            $table->unsignedInteger('plant_age_days')->nullable();
            $table->string('growth_stage')->nullable();
            $table->unsignedInteger('flower_count')->nullable();
            $table->decimal('flower_diameter_cm', 8, 2)->nullable();
            $table->decimal('stem_length_cm', 8, 2)->nullable();
            $table->decimal('flower_weight_g', 8, 2)->nullable();
            $table->string('health_status')->nullable();
            $table->string('disease_status')->nullable();
            $table->string('disease_name')->nullable();
            $table->string('pest_status')->nullable();
            $table->string('pest_name')->nullable();
            $table->text('petal_damage')->nullable();
            $table->string('freshness')->nullable();
            $table->string('quality_grade')->nullable();
            $table->string('maturity')->nullable();
            $table->string('harvest_readiness')->nullable();
            $table->string('soil_type')->nullable();
            $table->decimal('temperature_c', 8, 2)->nullable();
            $table->decimal('humidity_percent', 8, 2)->nullable();
            $table->text('recent_rainfall')->nullable();
            $table->string('sunlight_level')->nullable();
            $table->string('cultivation_season')->nullable();
            $table->text('weather_impact')->nullable();
            $table->text('climate_impact')->nullable();
            $table->unsignedInteger('total_plants')->nullable();
            $table->unsignedInteger('flowers_harvested')->nullable();
            $table->decimal('yield_kg', 10, 2)->nullable();
            $table->decimal('production_cost_bdt', 12, 2)->nullable();
            $table->string('cost_basis')->nullable();
            $table->decimal('wholesale_price_bdt', 12, 2)->nullable();
            $table->string('wholesale_price_unit')->nullable();
            $table->decimal('retail_price_bdt', 12, 2)->nullable();
            $table->string('retail_price_unit')->nullable();
            $table->string('market_name')->nullable();
            $table->string('demand_level')->nullable();
            $table->string('highest_demand_season')->nullable();
            $table->text('farmer_problems')->nullable();
            $table->text('marketing_problems')->nullable();
            $table->text('transport_problems')->nullable();
            $table->text('storage_problems')->nullable();
            $table->text('weather_climate_problems')->nullable();
            $table->string('government_support')->nullable();
            $table->text('government_support_details')->nullable();
            $table->text('required_future_support')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('flower_samples', function (Blueprint $table) {
            $table->dropUnique(['sample_id']);

            $table->dropColumn([
                'sample_id', 'farm_id', 'farm_name', 'farmer_name',
                'plot_id', 'sample_date', 'time_of_day',
                'lighting_condition', 'environment_type', 'location',
                'flower_species', 'local_name', 'scientific_name',
                'variety', 'color', 'plant_age_days', 'growth_stage',
                'flower_count', 'flower_diameter_cm', 'stem_length_cm',
                'flower_weight_g', 'health_status', 'disease_status',
                'disease_name', 'pest_status', 'pest_name', 'petal_damage',
                'freshness', 'quality_grade', 'maturity', 'harvest_readiness',
                'soil_type', 'temperature_c', 'humidity_percent',
                'recent_rainfall', 'sunlight_level', 'cultivation_season',
                'weather_impact', 'climate_impact', 'total_plants',
                'flowers_harvested', 'yield_kg', 'production_cost_bdt',
                'cost_basis', 'wholesale_price_bdt', 'wholesale_price_unit',
                'retail_price_bdt', 'retail_price_unit', 'market_name',
                'demand_level', 'highest_demand_season', 'farmer_problems',
                'marketing_problems', 'transport_problems', 'storage_problems',
                'weather_climate_problems', 'government_support',
                'government_support_details', 'required_future_support'
            ]);
        });
    }
};

