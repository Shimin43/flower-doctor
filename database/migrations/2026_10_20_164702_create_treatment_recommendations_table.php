
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treatment_recommendations', function (Blueprint $table) {
            $table->id();

            $table->string('flower_species');
            $table->string('disease_name');
            $table->text('symptoms')->nullable();
            $table->text('cause')->nullable();
            $table->text('prevention')->nullable();
            $table->text('treatment')->nullable();
            $table->text('farmer_advice')->nullable();

            $table->string('treatment_type')->nullable();
            $table->text('safety_precautions')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['flower_species', 'disease_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treatment_recommendations');
    }
};
