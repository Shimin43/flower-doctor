<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flower_images', function (Blueprint $table) {
            $table->id();

            // Link each image to a flower sample
            $table->foreignId('flower_sample_id')
                ->constrained('flower_samples')
                ->cascadeOnDelete();

            // Image file information
            $table->string('image_path');
            $table->string('image_url')->nullable();

            // Image metadata
            $table->string('image_angle')->nullable();
            $table->string('lighting_condition')->nullable();
            $table->string('plant_part')->nullable();
            $table->string('image_quality')->nullable();

            // Future AI prediction results
            $table->string('predicted_flower_species')->nullable();
            $table->string('predicted_disease')->nullable();
            $table->decimal('prediction_confidence', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flower_images');
    }
};
