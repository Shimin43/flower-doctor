
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('flowers', function (Blueprint $table) {
            $table->decimal('market_value', 10, 2)->nullable();
            $table->string('market_value_unit')->nullable();
            $table->string('market_value_location')->nullable();
            $table->date('market_value_updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('flowers', function (Blueprint $table) {
            $table->dropColumn([
                'market_value',
                'market_value_unit',
                'market_value_location',
                'market_value_updated_at',
            ]);
        });
    }
};
