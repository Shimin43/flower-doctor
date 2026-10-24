
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('treatment_recommendations', function (Blueprint $table) {
            $table->string('pesticide_name')->nullable();
            $table->text('pesticide_usage')->nullable();
            $table->string('fertilizer_name')->nullable();
            $table->text('fertilizer_usage')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('treatment_recommendations', function (Blueprint $table) {
            $table->dropColumn([
                'pesticide_name',
                'pesticide_usage',
                'fertilizer_name',
                'fertilizer_usage',
            ]);
        });
    }
};
